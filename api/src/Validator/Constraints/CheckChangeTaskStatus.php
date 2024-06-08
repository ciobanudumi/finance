<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CheckChangeTaskStatus extends Constraint
{
    public string $messageStatusCannotBeChanged = 'The task status cannot be changed from "{currentStatus}" to "{desiredStatus}"';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}