<?php

declare(strict_types=1);

namespace App\StateProcessor;

use App\Entity\TaskPatchInstall;

readonly class EditTaskPatchInstallStateProcessor extends EditTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskPatchInstall::class;
    }
}