<?php

declare(strict_types=1);

namespace App\Register\Application\Register;

final readonly class RegisterUserCommand
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        private string $email,
        private string $password
    ){
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
}
