<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class MultiOrderDto
{
    /**
     * @var OrderDto[]
     */
    #[Assert\NotBlank]
    public array $data;
}