<?php

declare(strict_types=1);

namespace App\RSA\Domain;

use App\Shared\Settings\SettingsInterface;

final class RSAPrivate extends RSAKey
{
    /**
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings)
    {
        parent::__construct(
            $settings->get('root_path') . '/rsa',
            $settings->get('rsa')['private']
        );
    }
}
