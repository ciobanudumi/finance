<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CheckTaskHoldStatus extends Constraint
{
    public string $messageRequiredFields = 'These fields (holdCode, holdReason, holdExpectedResumeDate) are required when the status of the task is "hold"';
    public string $messageSpecificFields = 'These fields (holdCode, holdReason, holdExpectedResumeDate) are specific only when the status of the task is "hold"';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}