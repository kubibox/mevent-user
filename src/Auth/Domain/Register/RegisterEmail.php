<?php

declare(strict_types=1);

namespace App\Auth\Domain\Register;

use App\Shared\Domain\ValueObject\StringValueObject;

final class RegisterEmail extends StringValueObject
{
    /**
     * @param RegisterEmail $other
     *
     * @return bool
     */
    public final function isSame(RegisterEmail $other): bool
    {
        return trim($this->value()) === trim($other->value());
    }
}
