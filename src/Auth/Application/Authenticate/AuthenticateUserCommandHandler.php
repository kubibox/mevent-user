<?php

declare(strict_types=1);

namespace App\Auth\Application\Authenticate;

use App\Auth\Domain\AuthPassword;
use App\Auth\Domain\AuthUsername;
use App\Auth\Domain\InvalidPasswordException;

final readonly class AuthenticateUserCommandHandler
{
    /**
     * @param UserAuthenticator $authenticator
     */
    public function __construct(private UserAuthenticator $authenticator)
    {
    }

    /**
     * @throws InvalidPasswordException
     */
    public function __invoke(AuthenticateUserCommand $command): void
    {
        $username = new AuthUsername($command->username());
        $password = new AuthPassword($command->password());

        $this->authenticator->authenticate($username, $password);
    }
}
