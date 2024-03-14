<?php

declare(strict_types=1);

namespace App\Register\Application\Email;

readonly class EmailConfirmationParams
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

    /**
     * @param array $data
     *
     * @return EmailConfirmationParams
     */
    public static function createFromArray(array $data): EmailConfirmationParams
    {
        $email = $data['email'] ?? '';

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Got invalid data');
        }

        return new EmailConfirmationParams($email);
    }
}
