<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskSetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskSetRepository::class)]
#[ApiResource]
class TaskSet
{
    const TASK_SET_STATUS_NEW = "new";
    const TASK_SET_STATUS_TO_DO = "to_do";
    const TASK_SET_STATUS_HOLD = "hold";
    const TASK_SET_STATUS_CANCELLED = "cancelled";
    const TASK_SET_STATUS_COMPLETED = "completed";

    const TASK_SET_STATUSES = [
        self::TASK_SET_STATUS_NEW,
        self::TASK_SET_STATUS_TO_DO,
        self::TASK_SET_STATUS_HOLD,
        self::TASK_SET_STATUS_CANCELLED,
        self::TASK_SET_STATUS_COMPLETED
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: false, options: ["default" => self::TASK_SET_STATUS_NEW])]
    #[Assert\Choice(choices: self::TASK_SET_STATUSES)]
    private ?string $status = self::TASK_SET_STATUS_NEW;

    #[ORM\ManyToOne(inversedBy: 'taskSets')]
    private ?User $assignee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $planned = null;

    #[ORM\OneToMany(mappedBy: 'taskSet', targetEntity: Task::class)]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): self
    {
        $this->assignee = $assignee;

        return $this;
    }

    public function getPlanned(): ?\DateTimeInterface
    {
        return $this->planned;
    }

    public function setPlanned(?\DateTimeInterface $planned): self
    {
        $this->planned = $planned;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setTaskset($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getTaskset() === $this) {
                $task->setTaskset(null);
            }
        }

        return $this;
    }
}
