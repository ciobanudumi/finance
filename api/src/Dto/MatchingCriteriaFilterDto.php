<?php

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class MatchingCriteriaFilterDto extends RegionMatchingCriteriaFilterDto
{
    #[Assert\NotBlank]
    public int $company;

    #[Assert\NotBlank]
    public string $taskType;
}