<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class RegionMatchingCriteriaFilterDto
{
    #[Assert\LessThanOrEqual(9999)]
    #[Assert\GreaterThanOrEqual(1000)]
    #[Assert\NotBlank]
    public int $region;
}