<?php

declare(strict_types=1);

namespace App\Auth\Domain;

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
     * @param AuthEmail $email
     *
     * @return bool
     */
    public function matchEmail(AuthEmail $email): bool
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
     * @return int
     */
    public function id(): int
    {
        return $this->id->value();
    }
}
