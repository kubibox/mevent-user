<?php

declare(strict_types=1);

namespace App\Register\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;

final class RegisteredUser extends AggregateRoot
{
    /**
     * @param int $id
     * @param RegisterEmail $email
     */
    public function __construct(
        private readonly int $id,
        private readonly RegisterEmail $email,
    ) {
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * @param RegisterEmail $email
     *
     * @return bool
     */
    public function matchEmail(RegisterEmail $email): bool
    {
        return $this->email->isSame($email);
    }

    /**
     * @return RegisterEmail
     */
    public function email(): RegisterEmail
    {
        return $this->email;
    }
}
