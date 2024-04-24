<?php

declare(strict_types=1);

namespace App\Token\Application\Generate;

use App\RSA\Domain\RSAPublic;
use App\Token\Domain\TokenData;
use App\Token\Domain\TokenIssue;
use App\Token\Domain\TokenPermitted;
use App\Token\Domain\TokenTtl;
use Exception;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;

readonly class TokenGenerator
{
    /**
     * @param RSAPublic $public
     */
    public function __construct(private RSAPublic $public)
    {
    }

    /**
     * @param TokenTtl $ttl
     * @param TokenData $data
     * @param TokenIssue $iss
     * @param TokenPermitted $aud
     *
     * @return UnencryptedToken
     * @throws Exception
     */
    public function generate(TokenTtl $ttl, TokenData $data, TokenIssue $iss, TokenPermitted $aud): UnencryptedToken
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::file($this->public->fullPath()),
        );

        return $config->builder()
            ->issuedBy($iss->value())
            ->permittedFor($aud->value())
            ->identifiedBy(uniqid('', true))
            ->issuedAt($ttl->now())
            ->expiresAt($ttl->asDateTime())
            ->withClaim('data', $data)
            ->getToken($config->signer(), $config->signingKey());
    }
}
