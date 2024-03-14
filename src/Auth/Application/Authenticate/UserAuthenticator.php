<?php

declare(strict_types=1);

namespace App\Auth\Application\Authenticate;

use App\Auth\Domain\AuthPassword;
use App\Auth\Domain\AuthRepository;
use App\Auth\Domain\AuthUser;
use App\Auth\Domain\AuthUsername;
use App\Auth\Domain\InvalidPasswordException;

final class UserAuthenticator
{
    /**
     * @param AuthRepository $repository
     */
    public function __construct(private readonly AuthRepository $repository)
    {
    }

    /**
     * @throws InvalidPasswordException
     */
    public function authenticate(AuthUsername $username, AuthPassword $password): void
    {
        $auth = $this->repository->search($username);

        $this->ensureCredentialsAreValid($auth, $password);

        $this->makeSession($auth);
    }

    private function makeSession(AuthUser $user): void
    {
        $_SESSION['USER_ID'] = $user->id(); //todo use GLOBAL METHOD
    }

    /**
     * @param AuthUser $user
     * @param AuthPassword $password
     * @return void
     * @throws InvalidPasswordException
     */
    private function ensureCredentialsAreValid(AuthUser $user, AuthPassword $password): void
    {
        if (!$user->matchPassword($password)) {
            throw new InvalidPasswordException($user);
        }
    }
}
