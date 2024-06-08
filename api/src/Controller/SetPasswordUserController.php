<?php

namespace App\Controller;

use AllowDynamicProperties;
use ApiPlatform\Validator\ValidatorInterface;
use App\ApiResource\DefaultResponseOutput;
use App\Dto\SetPasswordUserInputDto;
use App\Entity\User;
use App\Entity\UserPasswordToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties] class SetPasswordUserController extends AbstractController
{
    private ValidatorInterface $validator;
    public function __construct(ValidatorInterface $validator, private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $passwordHasher )
    {
        $this->validator = $validator;
    }
    public function __invoke(SetPasswordUserInputDto $userPasswordTokenDto): DefaultResponseOutput
    {
        $this->validator->validate($userPasswordTokenDto);

        $userPasswordTokenRepo = $this->entityManager->getRepository(UserPasswordToken::class);
        /** @var UserPasswordToken $userPasswordToken */
        $userPasswordToken = $userPasswordTokenRepo->findOneBy(['token'=>$userPasswordTokenDto->token]);
        if(!$userPasswordToken) {
            return new DefaultResponseOutput(['Invalid set password token'], false);
        }
        $userRepo = $this->entityManager->getRepository(User::class);
        if(!$user = $userRepo->find($userPasswordToken->getUser())) {
            return new DefaultResponseOutput(['Invalid User'], false);
        }
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $userPasswordTokenDto->password
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->entityManager->remove($userPasswordToken);
        $this->entityManager->flush();

        return new DefaultResponseOutput([], true);
    }
}
