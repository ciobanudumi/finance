<?php

namespace App\ApiResource;

final class DefaultResponseOutput
{

    public array $error;
    public bool $success;

    /**
     * @param array $error
     * @param bool $success
     */
    public function __construct(array $error, bool $success)
    {
        $this->error = $error;
        $this->success = $success;
    }
}