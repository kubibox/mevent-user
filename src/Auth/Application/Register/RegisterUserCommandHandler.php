<?php

namespace App\Auth\Application\Register;

use App\Auth\Domain\Register\RegisteredUser;
use App\Auth\Domain\Register\RegisterEmail;
use App\Auth\Domain\Register\RegisterPassword;

final class RegisterUserCommandHandler
{
    public function __construct(private readonly UserRegister $register)
    {
    }

    public function __invoke(RegisterUserCommand $registerUserCommand): RegisteredUser
    {
        $email = new RegisterEmail($registerUserCommand->email());
        $password = new RegisterPassword($registerUserCommand->password());

        return $this->register->register($email, $password);
    }
}