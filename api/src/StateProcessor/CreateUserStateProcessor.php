<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Entity\UserPasswordToken;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class CreateUserStateProcessor implements ProcessorInterface
{
    public function __construct(
        private string $mailerMailFrom,
        private string $financeClientSetPasswordRoute,
        private string $financeClientUrl,
        private MailerInterface $mailer,
        private SerializerInterface $serializer,
        private EntityManagerInterface $entityManager,
        private ProcessorInterface $processor,
        private TranslatorInterface $translator
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []):mixed
    {
        /** @var User $user */
        $user = $this->serializer->deserialize(json_encode($data), User::class, 'json');

        $user->setUsername(preg_replace("/[^a-zA-Z0-9]+/", "",str_replace(' ', '.', $user->getName())));

        while($this->entityManager->getRepository(User::class)->findBy(['username'=>$user->getUsername()])){
            $user->setUsername($user->getUsername().'.'.bin2hex(random_bytes(1)));
        }

        $userPasswordTokenRepository = $this->entityManager->getRepository(UserPasswordToken::class);
        $userPasswordToken = new UserPasswordToken();

        $token = bin2hex(random_bytes(60));
        while($userPasswordTokenRepository->findBy(['token'=>$token])){
            $token = bin2hex(random_bytes(60));
        }

        $userPasswordToken->setUser($user);
        $userPasswordToken->setToken($token);

        $this->entityManager->persist($userPasswordToken);
        $this->entityManager->flush();

        $this->sendEmail($user, $token);
        return $this->processor->process($user, $operation, $uriVariables, $context);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(User $user,  string $token):void{
        $email = (new TemplatedEmail())
            ->from($this->mailerMailFrom)
            ->to($user->getEmail())
            ->subject($this->translator->trans('Set Password'))
            ->htmlTemplate('emails/newUserEmail.html.twig')
            ->context([
                'user' => $user,
                'setPasswordURL' => $this->financeClientUrl.$this->financeClientSetPasswordRoute.'?'.'token='.$token,
            ]);

        $this->mailer->send($email);
    }
}
