<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Register\Domain\RegisterEmail;
use App\Shared\Domain\Aggregate\AggregateRoot;

class AuthUser extends AggregateRoot
{
    /**
     * @param AuthUsername $username
     * @param AuthPassword $password
     * @param AuthId $id
     * @param AuthEmail $email
     */
    public function __construct(
        protected readonly AuthUsername $username,
        protected readonly AuthPassword $password,
        protected readonly AuthId $id,
        protected readonly AuthEmail $email
    ) {
    }

    /**
     * @param AuthEmail|RegisterEmail $email
     *
     * @return bool
     */
    public function matchEmail(AuthEmail|RegisterEmail $email): bool
    {
        return $this->email->isSame($email);
    }

    /**
     * @param AuthPassword $password
     *
     * @return bool
     */
    public function matchPassword(AuthPassword $password): bool
    {
        return $this->password->isSame($password);
    }

    /**
     * @return AuthEmail
     */
    public function email(): AuthEmail
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id->value();
    }
}
