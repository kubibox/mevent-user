<?php

declare(strict_types=1);

namespace App\Token\Domain;

use DateInterval;
use DateTimeImmutable;
use Exception;

final readonly class TokenTtl
{
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $now;

    /**
     * @param int $value
     */
    public function __construct(private int $value)
    {
        $this->now = new DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return DateTimeImmutable
     * @throws Exception
     */
    public function asDateTime(): DateTimeImmutable
    {
        return $this->now()
            ->add(
                new DateInterval('PT' . $this->value() . 'S')
            );
    }

    /**
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
