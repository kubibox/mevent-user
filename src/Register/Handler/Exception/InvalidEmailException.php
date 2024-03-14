<?php

declare(strict_types=1);

namespace App\Register\Handler\Exception;

use App\Auth\Domain\AuthUser;

class InvalidEmailException extends \InvalidArgumentException
{
    /**
     * @param AuthUser $user
     */
    public function __construct(AuthUser $user)
    {
        parent::__construct($user->email()->value());
    }
}
