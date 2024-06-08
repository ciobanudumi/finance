<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class MoveTaskDto
{
    #[Assert\Type('int')]
    #[Assert\NotBlank]
    public ?int $taskId = null;

    #[Assert\Type('int')]
    public ?int $taskSetId = null;
}