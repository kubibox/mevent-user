<?php

declare(strict_types=1);

namespace App\Register\Application\Email\Confirmation;

use App\Auth\Domain\AuthEmail;
use App\Auth\Domain\InvalidPasswordException;
use App\Register\Application\Email\EmailConfirmation;
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
     * @throws InvalidPasswordException
     * @throws TransportExceptionInterface
     */
    public function __invoke(SendConfirmationEmailCommand $command): void
    {
        $this->confirmation->confirm(new AuthEmail($command->email()));
    }
}
