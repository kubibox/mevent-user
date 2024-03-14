<?php

declare(strict_types=1);

namespace App\Register\Handler\Exception;

use App\Register\Domain\RegisteredUser;

class InvalidEmailException extends \InvalidArgumentException
{
    /**
     * @param RegisteredUser $user
     */
    public function __construct(RegisteredUser $user)
    {
        parent::__construct($user->email()->value());
    }
}
