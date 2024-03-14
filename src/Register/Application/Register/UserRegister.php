<?php

declare(strict_types=1);

namespace App\Register\Application\Register;

use App\Register\Domain\RegisteredUser;
use App\Register\Domain\RegisterEmail;
use App\Register\Domain\RegisterPassword;
use App\Register\Domain\RegisterRepository;
use App\Register\Domain\RegisterUser;
use InvalidArgumentException;

readonly class UserRegister
{
    /**
     * @param RegisterRepository $repository
     */
    public function __construct(private RegisterRepository $repository)
    {
    }

    /**
     * @param RegisterEmail $email
     * @param RegisterPassword $password
     *
     * @return RegisteredUser
     */
    public function register(RegisterEmail $email, RegisterPassword $password): RegisteredUser
    {
        $this->ensureCredentialsAreValid(
            $this->repository->searchByEmail($email)
        );

        $user = $this->repository->createNewUser(new RegisterUser($email, $password));

        $this->makeSession($user);

        return $user;
    }

    /**
     * @param RegisteredUser $user
     *
     * @return void
     */
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
