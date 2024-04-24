<?php

declare(strict_types=1);

namespace App\TemporaryAccessToken\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Token\Domain\Token;

final class TemporaryAccessToken extends AggregateRoot
{
    /**
     * @param TemporaryAccessTokenId $id
     * @param TemporaryAccessTokenEmail $email
     * @param Token $token
     * @param TemporaryAccessTokenExpiration $expiration
     */
    public function __construct(
        private readonly TemporaryAccessTokenId $id,
        private readonly TemporaryAccessTokenEmail $email,
        private readonly Token $token,
        private readonly TemporaryAccessTokenExpiration $expiration,
    ) {
    }
}
