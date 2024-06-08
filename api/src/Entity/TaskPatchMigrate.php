<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Doctrine\Annotation\SyncMerge as Merge;
use App\Repository\TaskPatchMigrateRepository;
use App\Trait\TaskPatchTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskPatchMigrateRepository::class)]
#[ApiResource]
class TaskPatchMigrate extends Task
{
    use TaskPatchTrait;

    protected string $taskType = TaskType::TASK_PATCH_MIGRATE;

    #[ORM\Column]
    #[Merge]
    private ?int $patchcordLength = null;

    #[ORM\Column]
    #[Merge]
    private ?int $patchcordThickness = null;

    /**
     * @return string
     */
    public function getTaskType(): string
    {
        return $this->taskType;
    }


    public function getPatchcordLength(): ?int
    {
        return $this->patchcordLength;
    }

    public function setPatchcordLength(int $patchcordLength): self
    {
        $this->patchcordLength = $patchcordLength;

        return $this;
    }

    public function getPatchcordThickness(): ?int
    {
        return $this->patchcordThickness;
    }

    public function setPatchcordThickness(int $patchcordThickness): self
    {
        $this->patchcordThickness = $patchcordThickness;

        return $this;
    }
}