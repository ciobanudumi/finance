<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ContactPersonDto
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    public string $name;

    #[Assert\Length(max: 100)]
    public ?string $street = null;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 6)]
    #[Assert\Regex('/^[0-9]{4}[A-Z]{2}$/')]
    public string $zipcode;

    #[Assert\Type('integer')]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(value: 1)]
    public int $houseNumber;

    #[Assert\Type('string')]
    #[Assert\Length(max: 10)]
    public ?string $houseNumberExtension = null;

    #[Assert\Type('integer')]
    public ?int $roomNumber = null;

    #[Assert\Length(max: 100)]
    public ?string $city = null;

    #[Assert\Length(max: 15)]
    #[Assert\NotBlank]
    public string $phoneNumber;

    #[Assert\Length(max: 15)]
    #[Assert\NotBlank]
    public string $mobileNumber;

    #[Assert\Email]
    #[Assert\Length(max: 255)]
    public ?string $emailAddress = null;

    public ?string $notes = null;
}