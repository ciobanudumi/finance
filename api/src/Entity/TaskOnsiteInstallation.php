<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TaskOnsiteInstallationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskOnsiteInstallationRepository::class)]
#[ApiResource]
class TaskOnsiteInstallation extends Task
{
    protected string $taskType = TaskType::TASK_ONSITE_INSTALLATION;
}
