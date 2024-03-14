<?php

declare(strict_types=1);

namespace App\Auth\Application;

use InvalidArgumentException;

final class AuthParams
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private readonly string $email,
        private readonly string $password
    ) {
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * @param array $data
     *
     * @return AuthParams
     */
    public static function createFromArray(array $data): AuthParams
    {
        $email = $data['email'] ?? '';
        if (!$email) {
            throw new InvalidArgumentException('Email could not be empty');
        }

        $password = $data['password'] ?? '';
        if (!$password) {
            throw new InvalidArgumentException('Password could not be empty');
        }

        return new AuthParams($email, $password);
    }
}
