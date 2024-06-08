<?php
declare(strict_types=1);


namespace App\Dto;

use App\Entity\Task;
use App\Entity\TaskType;
use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskDto
{
    protected string $taskType = TaskType::TASK;

    #[Assert\Type('string')]
    public ?string $taskSet = null;

    #[Assert\NotBlank]
    public string $company;

    #[Assert\Length(max: 100)]
    public ?string $onBehalfOf = null;

    #[Assert\NotBlank]
    #[Assert\Range(min: 1000, max: 9999)]
    public int $region;

    public ?string $preferredExecutor;

    #[Assert\NotNull]
    public bool $migration;

    #[Assert\Date]
    public ?string $wishDate;

    #[Assert\Date]
    public ?string $executionDate;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: Task::TASK_PORT_TYPES)]
    #[Assert\Length(max: 1)]
    public ?string $portType = null;

    #[Assert\Type('string')]
    #[Assert\Choice(choices: Task::TASK_STATUSES)]
    public ?string $status = Task::TASK_STATUS_TO_DO;

    public ?string $contactPerson = null;

}