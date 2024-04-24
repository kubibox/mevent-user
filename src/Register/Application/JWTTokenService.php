<?php

declare(strict_types=1);

namespace App\Register\Application;

use App\RSA\Domain\RSAPrivate;
use App\RSA\Domain\RSAPublic;
use App\Shared\Settings\SettingsInterface;
use App\Token\Domain\Token;

class JWTTokenService
{
    private const ISS_REGISTER = 'register'; //todo should be unique for each env

    /**
     * @var RSAPublic
     */
    private readonly RSAPublic $RSAPublic;

    /**
     * @var RSAPrivate
     */
    private readonly RSAPrivate $RSAPrivate;

    /**
     * @param SettingsInterface $settings
     */
    public function __construct(private readonly SettingsInterface $settings)
    {
        $this->RSAPrivate = new RSAPrivate($settings);
        $this->RSAPublic = new RSAPublic($settings);
    }

    /**
     * @param string $email
     *
     * @return Token
     */
    public function getTokenForEmailConfirm(string $email): Token
    {
        return new Token(
            $this->RSAPublic,
            $this->RSAPrivate,
            self::ISS_REGISTER,
            $email,
        );
    }
}
