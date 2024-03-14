<?php

declare(strict_types=1);

namespace App\Auth\Application\Email\Confirmation;

use Symfony\Component\Mailer\MailerInterface;

readonly class SendConfirmationEmailCommandHandler
{
    /**
     * @param MailerInterface $mailer
     */
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke()
    {

    }
}
