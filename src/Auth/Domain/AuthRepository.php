<?php

declare(strict_types=1);

namespace App\Auth\Domain;

interface AuthRepository
{
    /**
     * @param AuthEmail $email
     *
     * @return AuthUser
     */
    public function searchEmail(AuthEmail $email): AuthUser;

    /**
     * @param AuthUsername $username
     *
     * @return AuthUser
     */
    public function search(AuthUsername $username): AuthUser;
}
