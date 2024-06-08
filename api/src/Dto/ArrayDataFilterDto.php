<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class ArrayDataFilterDto
{
    /**
     * @var array
     */
    #[Assert\NotBlank]
    public array $data;
}