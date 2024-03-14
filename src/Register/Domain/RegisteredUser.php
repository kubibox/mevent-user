<?php

declare(strict_types=1);
namespace App\Register\Domain;

final class RegisteredUser
{
    /**
     * @param RegisterId $id
     * @param RegisterEmail $email
     */
    public function __construct(
        private readonly RegisterId $id,
        private readonly RegisterEmail $email,
    ) {
    }

    /**
     * @return RegisterId
     */
    public function id(): RegisterId
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
