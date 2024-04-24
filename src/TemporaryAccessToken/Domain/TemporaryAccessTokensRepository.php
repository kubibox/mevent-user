<?php

declare(strict_types=1);

namespace App\TemporaryAccessToken\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

interface TemporaryAccessTokensRepository
{
    /**
     * @param StringValueObject $email
     *
     * @return mixed
     */
    public function findByEmail(StringValueObject $email): TemporaryAccessToken;

    /**
     * @param TemporaryAccessToken $temporaryAccessToken
     *
     * @return void
     */
    public function save(TemporaryAccessToken $temporaryAccessToken): void;
}
