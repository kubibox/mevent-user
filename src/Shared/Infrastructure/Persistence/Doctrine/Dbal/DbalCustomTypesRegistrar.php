<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\Dbal;

use function PHPUnit\Framework\callback;

final class DbalCustomTypesRegistrar
{
    private static bool $initialized = false;

    public static function register(array $customTypeClassNames): void
    {
        if (self::$initialized) {
            return;
        }

        foreach ($customTypeClassNames as $customTypeClassName) {
            callback(self::registerType(), $customTypeClassName);
        }

        self::$initialized = true;
    }

    private static function registerType(): callable
    {
        return static function (string $customTypeClassName): void {
            Type::addType($customTypeClassName::customTypeName(), $customTypeClassName); //todo create type
        };
    }
}
