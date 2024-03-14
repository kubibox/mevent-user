<?php

namespace App\Auth\Domain\Register;

use App\Shared\Domain\ValueObject\StringValueObject;

final class RegisterPassword extends StringValueObject
{
    public function value(): string
    {
        return $this->hash();
    }

    public function hash(): string
    {
        return password_hash($this->value, PASSWORD_DEFAULT);
    }
}
