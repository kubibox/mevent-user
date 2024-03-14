<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Persistence;

use App\Auth\Domain\AuthEmail;
use App\Auth\Domain\AuthId;
use App\Auth\Domain\AuthPassword;
use App\Auth\Domain\AuthUser;
use App\Auth\Domain\AuthUsername;
use App\Auth\Domain\Register\RegisteredUser;
use App\Auth\Domain\Register\RegisterEmail;
use App\Auth\Domain\Register\RegisterRepository;
use App\Auth\Domain\Register\RegisterUser;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class DoctrineRegisterRepository extends DoctrineRepository implements RegisterRepository
{

    /**
     * @param RegisterEmail $email
     *
     * @return RegisteredUser
     */
    public function searchByEmail(RegisterEmail $email): RegisteredUser
    {
        // TODO: Implement searchByEmail() method.
    }

    /**
     * @param RegisterUser $user
     *
     * @return RegisteredUser
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createNewUser(RegisterUser $user): RegisteredUser
    {
        $auth = new AuthUser(
            new AuthUsername($user->email()->value()),
            new AuthPassword($user->password()->value()),
            new AuthId(0),
            new AuthEmail($user->email()->value())
        );

        $this->persist($auth);
    }
}
