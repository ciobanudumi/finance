<?php

declare(strict_types=1);

namespace App\StateProcessor;

use App\Entity\TaskOnsiteInstallation;

readonly class EditTaskOnsiteInstallationStateProcessor extends EditTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskOnsiteInstallation::class;
    }
}