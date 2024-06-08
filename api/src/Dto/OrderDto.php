<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class OrderDto
{
    const ORDER_TYPES = ['asc', 'desc'];

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    public string $sortBy;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: self::ORDER_TYPES)]
    public string $order;
}