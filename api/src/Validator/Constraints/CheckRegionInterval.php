<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CheckRegionInterval extends Constraint
{
    public string $messageInvalidRegionInterval = 'The region interval [{min}, {max}] is not valid. Please provide a valid interval.';

    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}