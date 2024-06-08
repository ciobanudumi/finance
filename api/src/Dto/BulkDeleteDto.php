<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BulkDeleteDto
{
    #[Assert\NotBlank]
    #[Assert\Type('array')]
    public array $ids;
}