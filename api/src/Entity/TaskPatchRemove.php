<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskPatchRemoveRepository;
use App\Trait\TaskPatchTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskPatchRemoveRepository::class)]
#[ApiResource]
class TaskPatchRemove extends Task
{
    use TaskPatchTrait;

    protected string $taskType = TaskType::TASK_PATCH_REMOVE;
}
