<?php

namespace App\Auth\Domain\Register;

use App\Shared\Domain\ValueObject\StringValueObject;

final class RegisterEmail extends StringValueObject
{
    public final function isSame(RegisterEmail $other): bool
    {
        return trim($this->value()) === trim($other->value());
    }
}