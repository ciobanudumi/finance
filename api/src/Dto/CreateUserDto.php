<?php

namespace App\Dto;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserDto
{
    #[Assert\Email]
    #[Assert\Length(max: 225)]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(max: 100)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: User::ALLOWED_ROLES, multiple: true)]
    public array $roles;

    #[Assert\NotBlank]
    public array $companies;
}