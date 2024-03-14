<?php

namespace App\Auth\Application\Register;

use App\Auth\Domain\Register\RegisteredUser;
use App\Auth\Domain\Register\RegisterEmail;
use App\Auth\Domain\Register\RegisterPassword;
use App\Auth\Domain\Register\RegisterRepository;
use App\Auth\Domain\Register\RegisterUser;
use InvalidArgumentException;

class UserRegister
{
    public function __construct(private readonly RegisterRepository $repository)
    {
    }

    public function register(RegisterEmail $email, RegisterPassword $password): RegisteredUser
    {
        $this->ensureCredentialsAreValid(
            $this->repository->searchByEmail($email)
        );

        $user = $this->repository->createNewUser(new RegisterUser($email, $password));

        $this->makeSession($user);

        return $user;
    }

    private function makeSession(RegisteredUser $user): void
    {
        $_SESSION['USER_ID'] = $user->id(); //todo use GLOBAL METHOD
    }

    /**
     * @param RegisteredUser $user
     * @return void
     */
    private function ensureCredentialsAreValid(RegisteredUser $user): void
    {
        if (!$user->isUnique()) {
            throw new InvalidArgumentException('Invalid email'); //todo throw normal exception
        }
    }
}