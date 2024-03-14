<?php

namespace App\Auth\Domain;

use Exception;

class InvalidPasswordException extends Exception
{
    public function __construct(AuthUser $user)
    {
        parent::__construct('Invalid user password');
    }
}