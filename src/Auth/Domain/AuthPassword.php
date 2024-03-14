<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

class AuthPassword extends StringValueObject
{
    public function hash(): string
    {
        return password_hash($this->value(), PASSWORD_DEFAULT);
    }

    public function isSame(AuthPassword $other): bool
    {
        return password_verify($other->value(), $this->value());
    }
}
