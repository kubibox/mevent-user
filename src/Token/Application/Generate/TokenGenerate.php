<?php

declare(strict_types=1);

namespace App\Token\Application\Generate;

use App\Token\Domain\Token;
use App\Token\Domain\TokenData;
use App\Token\Domain\TokenIssue;
use App\Token\Domain\TokenPermitted;
use App\Token\Domain\TokenTtl;
use Exception;

readonly class TokenGenerate
{
    /**
     * @param TokenGenerator $tokenGenerator
     */
    public function __construct(private TokenGenerator $tokenGenerator)
    {
    }

    /**
     * @param TokenGenerateArguments $generateArguments
     *
     * @return Token
     * @throws Exception
     */
    public function generate(TokenGenerateArguments $generateArguments): Token
    {
        $unencryptedToken = $this->tokenGenerator->generate(
            new TokenTtl($generateArguments->ttl()),
            new TokenData($generateArguments->data()),
            new TokenIssue($generateArguments->iss()),
            new TokenPermitted($generateArguments->aud()),
        );

        return new Token($unencryptedToken);
    }
}
