<?php

declare(strict_types=1);

namespace App\TemporaryAccessToken\Domain;

final readonly class TemporaryAccessTokenExpiration
{
    /**
     * @param string $value
     */
    public function __construct(private string $value)
    {
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
