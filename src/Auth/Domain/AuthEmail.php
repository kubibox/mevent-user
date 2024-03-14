<?php

declare(strict_types=1);

namespace App\Auth\Domain;

use App\Register\Domain\RegisterEmail;
use App\Shared\Domain\ValueObject\StringValueObject;

final class AuthEmail extends StringValueObject
{
    /**
     * @param AuthEmail|RegisterEmail $other
     *
     * @return bool
     */
    public function isSame(AuthEmail|RegisterEmail $other): bool
    {
        return trim($other->value()) === trim($this->value());
    }
}
