<?php

declare(strict_types=1);

namespace App\Register\Application\Email\Confirmation;

use App\Auth\Domain\AuthEmail;
use App\Auth\Domain\InvalidPasswordException;
use App\Register\Application\Email\EmailConfirmation;
use App\Register\Domain\RegisterEmail;
use App\Register\Handler\Exception\EmailAlreadyExistedException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

readonly class SendConfirmationEmailCommandHandler
{
    /**
     * @param EmailConfirmation $confirmation
     */
    public function __construct(private EmailConfirmation $confirmation)
    {
    }

    /**
     * @param SendConfirmationEmailCommand $command
     *
     * @return void
     * @throws TransportExceptionInterface
     * @throws EmailAlreadyExistedException
     */
    public function __invoke(SendConfirmationEmailCommand $command): void
    {
        $this->confirmation->confirm(new RegisterEmail($command->email()));
    }
}
