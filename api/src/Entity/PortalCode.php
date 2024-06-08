<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PortalCodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortalCodeRepository::class)]
#[ApiResource]
class PortalCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $type = null;

    #[ORM\Column(nullable: false, unique: true)]
    private ?int $code = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: TaskType::class, mappedBy: 'portalCodes')]
    private Collection $taskTypes;

    #[ORM\OneToMany(mappedBy: 'holdCode', targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->taskTypes = new ArrayCollection();
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PortalCode
     */
    public function setId(?int $id): PortalCode
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return PortalCode
     */
    public function setType(?string $type): PortalCode
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     * @return PortalCode
     */
    public function setCode(?int $code): PortalCode
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return PortalCode
     */
    public function setDescription(?string $description): PortalCode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getTaskTypes(): Collection
    {
        return $this->taskTypes;
    }

    /**
     * @param Collection $taskTypes
     * @return PortalCode
     */
    public function setTaskTypes(Collection $taskTypes): PortalCode
    {
        $this->taskTypes = $taskTypes;
        return $this;
    }

    public function addTaskType(TaskType $taskType): self
    {
        if (!$this->taskTypes->contains($taskType)) {
            $this->taskTypes->add($taskType);
        }

        return $this;
    }

    public function removeTaskType(TaskType $taskType): self
    {
        $this->taskTypes->removeElement($taskType);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * @param Collection $tasks
     * @return PortalCode
     */
    public function setTasks(Collection $tasks): PortalCode
    {
        $this->tasks = $tasks;
        return $this;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        $this->tasks->removeElement($task);

        return $this;
    }

}