<?php

namespace App\Entity;

use AllowDynamicProperties;
use ApiPlatform\Metadata\ApiResource;
use App\Doctrine\Annotation\SyncMerge as Merge;
use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Gedmo\Mapping\Annotation as Gedmo;

#[AllowDynamicProperties]
#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'task_type', type: 'string')]
#[DiscriminatorMap([
    TaskType::TASK => Task::class,
    TaskType::TASK_PATCH_INSTALL => TaskPatchInstall::class,
    TaskType::TASK_PATCH_MIGRATE => TaskPatchMigrate::class,
    TaskType::TASK_PATCH_REMOVE => TaskPatchRemove::class,
    TaskType::TASK_ONSITE_INSTALLATION => TaskOnsiteInstallation::class
])]
#[ApiResource]
class Task
{
    const TASK_STATUS_TO_DO = "to_do";
    const TASK_STATUS_HOLD = "hold";
    const TASK_STATUS_CANCEL = "cancel";
    const TASK_STATUS_DONE = "done";
    const TASK_STATUSES = [
        self::TASK_STATUS_TO_DO,
        self::TASK_STATUS_HOLD,
        self::TASK_STATUS_CANCEL,
        self::TASK_STATUS_DONE
    ];

    const TASK_PORT_TYPES = ['A', 'B'];

    protected string $taskType = TaskType::TASK;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Merge]
    private ?Company $company = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Merge]
    private ?string $onBehalfOf = null;

    #[ORM\Column(nullable: false)]
    #[Merge]
    private ?int $region = null;

    #[ORM\ManyToOne(inversedBy: 'preferredExecutorTasks')]
    #[ORM\JoinColumn(nullable: true)]
    #[Merge]
    private ?User $preferredExecutor = null;

    #[ORM\Column]
    #[Merge]
    private ?bool $migration = false;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Merge]
    private ?\DateTimeInterface $wishDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Merge]
    private ?\DateTimeInterface $executionDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finished = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?TaskSet $taskSet = null;

    #[ORM\OneToOne(cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?ContactPerson $contactPerson = null;

    #[ORM\Column(length: 1, nullable: true)]
    #[Merge]
    private ?string $portType = null;

    #[ORM\Column(length: 20, nullable: false, options: ["default" => self::TASK_STATUS_TO_DO])]
    private ?string $status = self::TASK_STATUS_TO_DO;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: true)]
    private ?PortalCode $holdCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $holdReason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $holdExpectedResumeDate = null;

    /**
     * @return string
     */
    public function getTaskType(): string
    {
        return $this->taskType;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     */
    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string|null
     */
    public function getOnBehalfOf(): ?string
    {
        return $this->onBehalfOf;
    }

    /**
     * @param string|null $onBehalfOf
     */
    public function setOnBehalfOf(?string $onBehalfOf): void
    {
        $this->onBehalfOf = $onBehalfOf;
    }

    /**
     * @return int|null
     */
    public function getRegion(): ?int
    {
        return $this->region;
    }

    /**
     * @param int|null $region
     */
    public function setRegion(?int $region): void
    {
        $this->region = $region;
    }

    /**
     * @return User|null
     */
    public function getPreferredExecutor(): ?User
    {
        return $this->preferredExecutor;
    }

    /**
     * @param User|null $preferredExecutor
     */
    public function setPreferredExecutor(?User $preferredExecutor): void
    {
        $this->preferredExecutor = $preferredExecutor;
    }

    /**
     * @return bool|null
     */
    public function getMigration(): ?bool
    {
        return $this->migration;
    }

    /**
     * @param bool|null $migration
     */
    public function setMigration(?bool $migration): void
    {
        $this->migration = $migration;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getWishDate(): ?\DateTimeInterface
    {
        return $this->wishDate;
    }

    /**
     * @param \DateTimeInterface|null $wishDate
     */
    public function setWishDate(?\DateTimeInterface $wishDate): void
    {
        $this->wishDate = $wishDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getExecutionDate(): ?\DateTimeInterface
    {
        return $this->executionDate;
    }

    /**
     * @param \DateTimeInterface|null $executionDate
     */
    public function setExecutionDate(?\DateTimeInterface $executionDate): void
    {
        $this->executionDate = $executionDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getFinished(): ?\DateTimeInterface
    {
        return $this->finished;
    }

    /**
     * @param \DateTimeInterface|null $finished
     */
    public function setFinished(?\DateTimeInterface $finished): void
    {
        $this->finished = $finished;
    }

    /**
     * @return TaskSet|null
     */
    public function getTaskSet(): ?TaskSet
    {
        return $this->taskSet;
    }

    /**
     * @param TaskSet|null $taskSet
     */
    public function setTaskSet(?TaskSet $taskSet): void
    {
        $this->taskSet = $taskSet;
    }

    /**
     * @return ContactPerson|null
     */
    public function getContactPerson(): ?ContactPerson
    {
        return $this->contactPerson;
    }

    /**
     * @param ContactPerson|null $contactPerson
     */
    public function setContactPerson(?ContactPerson $contactPerson): void
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * @return string|null
     */
    public function getPortType(): ?string
    {
        return $this->portType;
    }

    /**
     * @param string|null $portType
     */
    public function setPortType(?string $portType): void
    {
        $this->portType = $portType;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return Task
     */
    public function setStatus(?string $status): Task
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return PortalCode|null
     */
    public function getHoldCode(): ?PortalCode
    {
        return $this->holdCode;
    }

    /**
     * @param PortalCode|null $holdCode
     * @return Task
     */
    public function setHoldCode(?PortalCode $holdCode): Task
    {
        $this->holdCode = $holdCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHoldReason(): ?string
    {
        return $this->holdReason;
    }

    /**
     * @param string|null $holdReason
     * @return Task
     */
    public function setHoldReason(?string $holdReason): Task
    {
        $this->holdReason = $holdReason;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getHoldExpectedResumeDate(): ?\DateTimeInterface
    {
        return $this->holdExpectedResumeDate;
    }

    /**
     * @param \DateTimeInterface|null $holdExpectedResumeDate
     * @return Task
     */
    public function setHoldExpectedResumeDate(?\DateTimeInterface $holdExpectedResumeDate): Task
    {
        $this->holdExpectedResumeDate = $holdExpectedResumeDate;
        return $this;
    }

}
