<?php

declare(strict_types=1);

namespace App\Register\Application\Register;

use App\Register\Domain\RegisteredUser;
use App\Register\Domain\RegisterEmail;
use App\Register\Domain\RegisterPassword;

final class RegisterUserCommandHandler
{
    /**
     * @param UserRegister $register
     */
    public function __construct(private readonly UserRegister $register)
    {
    }

    /**
     * @param RegisterUserCommand $registerUserCommand
     *
     * @return RegisteredUser
     */
    public function __invoke(RegisterUserCommand $registerUserCommand): RegisteredUser
    {
        $email = new RegisterEmail($registerUserCommand->email());
        $password = new RegisterPassword($registerUserCommand->password());

        return $this->register->register($email, $password);
    }
}
