<?php

declare(strict_types=1);

namespace App\Token\Domain;

interface TokeRepository
{
    /**
     * @return Token
     */
    public function generate(): Token;
}
