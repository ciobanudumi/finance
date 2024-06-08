<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class EditTaskPatchDto extends CreateTaskPatchDto
{
    #[Assert\Type('int')]
    #[Assert\NotBlank]
    public int $taskId;
}