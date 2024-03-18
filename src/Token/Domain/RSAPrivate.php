<?php

declare(strict_types=1);

namespace App\Token\Domain;

use App\Shared\Settings\SettingsInterface;
use App\Token\Shared\Domain\RSAKey;

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
