<?php
declare(strict_types=1);


namespace App\StateProcessor;

use App\Entity\TaskPatchInstall;

readonly class CreateTaskPatchInstallStateProcessor extends CreateTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskPatchInstall::class;
    }
}