<?php

declare(strict_types=1);

namespace App\StateProcessor;

use App\Entity\TaskPatchMigrate;

readonly class EditTaskPatchMigrateStateProcessor extends EditTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskPatchMigrate::class;
    }
}