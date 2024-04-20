<?php

declare(strict_types=1);

namespace App\Register\Handler\Exception;

use App\Register\Domain\RegisteredUser;

class InvalidEmailException extends \InvalidArgumentException
{
    /**
     * @param string $user
     */
    public function __construct(string $email)
    {
        parent::__construct($email);
    }
}
