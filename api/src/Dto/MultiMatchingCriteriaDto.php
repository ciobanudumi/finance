<?php

namespace App\Dto;
use App\Validator\Constraints\CheckRegionInterval;
use Symfony\Component\Validator\Constraints as Assert;

#[CheckRegionInterval]
class MultiMatchingCriteriaDto
{
    #[Assert\NotBlank]
    public array $users;
    #[Assert\NotBlank]
    public array $companies;
    #[Assert\NotBlank]
    public array $taskTypes;

    #[Assert\LessThanOrEqual(9999)]
    #[Assert\GreaterThanOrEqual(1000)]
    #[Assert\NotBlank]
    public int $minRegion;

    #[Assert\LessThanOrEqual(9999)]
    #[Assert\GreaterThanOrEqual(1000)]
    #[Assert\NotBlank]
    public int $maxRegion;

    /**
     * @return int
     */
    public function getMinRegion(): int
    {
        return $this->minRegion;
    }

    /**
     * @return int
     */
    public function getMaxRegion(): int
    {
        return $this->maxRegion;
    }

}