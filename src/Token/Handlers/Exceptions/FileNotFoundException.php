<?php

declare(strict_types=1);

namespace App\Token\Handlers\Exceptions;

use InvalidArgumentException;

final class FileNotFoundException extends InvalidArgumentException
{
    public static function new(string $file): self
    {
        return new self(sprintf('Database configuration file "%s" does not exist.', $file));
    }
}
