<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class EditContactPersonDto extends ContactPersonDto
{
    #[Assert\NotBlank]
    #[Assert\Type('int')]
    public ?int $contactPersonId = null;
}