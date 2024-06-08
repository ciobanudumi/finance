<?php

declare(strict_types=1);

namespace App\StateProcessor;

use App\Entity\TaskPatchRemove;

readonly class CreateTaskPatchRemoveStateProcessor extends CreateTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskPatchRemove::class;
    }
}