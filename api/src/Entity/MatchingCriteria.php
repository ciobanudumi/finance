<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MatchingCriteriaRepository;
use App\Validator\Constraints\CheckRegionInterval;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchingCriteriaRepository::class)]
#[ApiResource]
#[CheckRegionInterval]
class MatchingCriteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matchingCriterias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'matchingCriterias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column]
    private ?int $minRegion = null;

    #[ORM\Column]
    private ?int $maxRegion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TaskType $taskType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return MatchingCriteria
     */
    public function setUser(?User $user): MatchingCriteria
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return MatchingCriteria
     */
    public function setCompany(?Company $company): MatchingCriteria
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinRegion(): ?int
    {
        return $this->minRegion;
    }

    /**
     * @param int|null $minRegion
     * @return MatchingCriteria
     */
    public function setMinRegion(?int $minRegion): MatchingCriteria
    {
        $this->minRegion = $minRegion;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxRegion(): ?int
    {
        return $this->maxRegion;
    }

    /**
     * @param int|null $maxRegion
     * @return MatchingCriteria
     */
    public function setMaxRegion(?int $maxRegion): MatchingCriteria
    {
        $this->maxRegion = $maxRegion;
        return $this;
    }

    /**
     * @return TaskType|null
     */
    public function getTaskType(): ?TaskType
    {
        return $this->taskType;
    }

    /**
     * @param TaskType|null $taskType
     * @return MatchingCriteria
     */
    public function setTaskType(?TaskType $taskType): MatchingCriteria
    {
        $this->taskType = $taskType;
        return $this;
    }

}
