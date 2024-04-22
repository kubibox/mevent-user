<?php

namespace App\Register\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use JetBrains\PhpStorm\Pure;

final class RegisterUser extends AggregateRoot
{
    /**
     * @param RegisterEmail $email
     * @param RegisterPassword $password
     */
    public function __construct(
        public readonly RegisterEmail $email,
        public readonly RegisterPassword $password
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

    /**
     * @param RegisterEmail $email
     *
     * @return bool
     */
    public function matchEmail(RegisterEmail $email): bool
    {
        return $this->email->isSame($email);
    }
}
