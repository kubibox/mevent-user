<?php

namespace App\Auth\Domain\Register;

use JetBrains\PhpStorm\Pure;

final class RegisterUser
{
    public function __construct(
        private readonly RegisterEmail $email,
        private readonly RegisterPassword $password
    ) {
    }

    public function email(): RegisterEmail
    {
        return $this->email;
    }

    public function password(): RegisterPassword
    {
        return $this->password;
    }

    public function fistName(): string
    {
        return explode('@', $this->email->value())[0];
    }

    #[Pure(true)]
    public function createdAt(): string
    {
        return date('Y-m-d H:i:s'); // todo use const for this format
    }
}
