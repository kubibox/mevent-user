<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface ToPrimitivesInterface
{
    public function toPrimitives(): array;
}
