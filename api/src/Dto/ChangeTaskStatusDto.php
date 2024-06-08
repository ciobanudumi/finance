<?php

namespace App\Dto;

use App\Entity\Task;
use App\Validator\Constraints\CheckTaskHoldStatus;
use App\Validator\Constraints\CheckChangeTaskStatus;
use Symfony\Component\Validator\Constraints as Assert;

#[CheckTaskHoldStatus]
#[CheckChangeTaskStatus]
class ChangeTaskStatusDto
{
    #[Assert\Type('int')]
    #[Assert\NotBlank]
    public int $taskId;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: Task::TASK_STATUSES)]
    public string $status;

    #[Assert\Type('int')]
    public ?int $holdCode = null;

    #[Assert\Length(max: 255)]
    public ?string $holdReason = null;

    #[Assert\Date]
    public ?string $holdExpectedResumeDate = null;
}