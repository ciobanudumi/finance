<?php

declare(strict_types=1);

namespace App\Exception;

/**
 * Exception that should be thrown when an email notification is not desired.
 */
class NoSendEmailException extends \Exception
{
    protected array $extra;

    final public function getExtra(): array
    {
        return $this->extra;
    }

    final public function setExtra(array $extra): void
    {
        $this->extra = $extra;
    }
}
