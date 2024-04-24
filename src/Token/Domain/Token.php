<?php

declare(strict_types=1);

namespace App\Token\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use Lcobucci\JWT\UnencryptedToken;

final class Token extends AggregateRoot
{
    /**
     * @param UnencryptedToken $unencryptedToken
     */
    public function __construct(private readonly UnencryptedToken $unencryptedToken)
    {
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->unencryptedToken->toString();
    }
}
