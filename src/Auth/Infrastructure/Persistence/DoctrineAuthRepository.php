<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Persistence;

use App\Auth\Domain\AuthEmail;
use App\Auth\Domain\AuthRepository;
use App\Auth\Domain\AuthUser;
use App\Auth\Domain\AuthUsername;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineAuthRepository extends DoctrineRepository implements AuthRepository
{
    /**
     * @param AuthUsername $username
     *
     * @return AuthUser
     */
    #[\Override] public function search(AuthUsername $username): AuthUser
    {
        // TODO: Implement search() method.
    }

    /**
     * @param AuthEmail $email
     *
     * @return AuthUser
     */
    #[\Override] public function searchEmail(AuthEmail $email): AuthUser
    {
        // TODO: Implement searchEmail() method.
    }
}
