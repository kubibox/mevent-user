<?php

declare(strict_types=1);

namespace App\Token\Domain;

final readonly class TokenData
{
    /**
     * @param array $value
     */
    public function __construct(private array $value)
    {
    }

    /**
     * @return array
     */
    public function value(): array
    {
        return $this->value;
    }
}
