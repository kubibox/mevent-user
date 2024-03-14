<?php

declare(strict_types=1);

namespace App\Auth\Application\Authenticate;

final readonly class AuthenticateUserCommand
{
    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(private string $username, private string $password)
    {
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }
}
