<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
final readonly class SetPasswordUserStateProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $processor, private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []):mixed
    {
        if (!$data->getPassword()) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );
        $data->setPassword($hashedPassword);
        $data->eraseCredentials();
        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}