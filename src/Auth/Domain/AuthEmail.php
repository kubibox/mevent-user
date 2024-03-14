<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

final class AuthEmail extends StringValueObject
{
    /**
     * @param AuthEmail $other
     *
     * @return bool
     */
    public function isSame(AuthEmail $other): bool
    {
        return trim($other->value()) === trim($this->value());
    }
}
