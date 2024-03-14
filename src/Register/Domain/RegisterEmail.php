<?php

declare(strict_types=1);

namespace App\Register\Domain;

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
