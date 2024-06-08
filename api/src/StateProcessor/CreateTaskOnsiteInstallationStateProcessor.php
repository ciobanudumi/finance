<?php
declare(strict_types=1);


namespace App\StateProcessor;

use App\Entity\TaskOnsiteInstallation;

readonly class CreateTaskOnsiteInstallationStateProcessor extends CreateTaskStateProcessor
{
    /**
     * @return string
     */
    protected function getObjectClass(): string
    {
        return TaskOnsiteInstallation::class;
    }
}