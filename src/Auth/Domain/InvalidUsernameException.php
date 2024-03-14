<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use Exception;
use Throwable;

class InvalidUsernameException extends Exception
{
    public function __construct(AuthUsername $username, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(sprintf('Cannot find user name %s', $username->value()), $code, $previous);
    }
}
