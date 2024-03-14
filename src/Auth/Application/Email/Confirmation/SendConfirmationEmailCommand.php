<?php

declare(strict_types=1);

namespace App\Auth\Application\Email\Confirmation;

readonly class SendConfirmationEmailCommand
{
    /**
     * @param string $email
     */
    public function __construct(private string $email)
    {
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }
}
