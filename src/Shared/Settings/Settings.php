<?php

declare(strict_types=1);

namespace App\Shared\Settings;

readonly class Settings implements SettingsInterface
{
    /**
     * @param array $settings
     */
    public function __construct(private array $settings)
    {
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key = ''): mixed
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }
}
