<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use Throwable;

interface VerificationInterface
{
    /**
     * @throws Throwable
     * @return void
     */
    public function verification(): void;
}
