<?php

declare(strict_types=1);

namespace App\Token\Application\Generate;

final readonly class TokenGenerateArguments
{
    /**
     * @param int $ttl
     * @param string $iss
     * @param string $aud
     * @param array $data
     */
    public function __construct(
        private int $ttl,
        private string $iss,
        private string $aud,
        private array $data,
    ) {
    }

    /**
     * @return int
     */
    public function ttl(): int
    {
        return $this->ttl;
    }

    /**
     * @return string
     */
    public function iss(): string
    {
        return $this->iss;
    }

    /**
     * @return string
     */
    public function aud(): string
    {
        return $this->aud;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }
}
