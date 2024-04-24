<?php

declare(strict_types=1);

namespace App\TemporaryAccessToken\Application\Create;

use App\TemporaryAccessToken\Domain\TemporaryAccessTokenEmail;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokenExpiration;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokenId;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokensRepository;
use App\Token\Domain\Token;
use App\TemporaryAccessToken\Domain\TemporaryAccessToken;

final readonly class TemporaryAccessTokenCreator
{
    /**
     * @param TemporaryAccessTokensRepository $repository
     */
    public function __construct(private TemporaryAccessTokensRepository $repository)
    {
    }

    /**
     * @param TemporaryAccessTokenId $id
     * @param TemporaryAccessTokenEmail $email
     * @param Token $token
     * @param TemporaryAccessTokenExpiration $expiration
     *
     * @return void
     */
    public function create(
        int $id,
        string $email,
        string $token,
        string $expiration //todo fix
    ): void {
        $temporaryAccessToken = new TemporaryAccessToken(
            new TemporaryAccessTokenId($id),
            new TemporaryAccessTokenEmail($email),
            new Token($token),
            new TemporaryAccessTokenExpiration($expiration),
        );

        $this->repository->save($temporaryAccessToken);
    }
}
