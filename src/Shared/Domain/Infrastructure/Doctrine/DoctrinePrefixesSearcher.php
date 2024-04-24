<?php

declare(strict_types=1);

namespace App\Shared\Domain\Infrastructure\Doctrine;

use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;

final class DoctrinePrefixesSearcher
{
    private const string MAPPINGS_PATH = 'Persistence/Doctrine';

    /**
     * @param string $path
     * @param string $baseNamespace
     *
     * @return array
     */
    public static function inPath(string $path, string $baseNamespace): array
    {
        $possibleMappingDirectories = self::possibleMappingPaths($path);
        $mappingDirectories = filter(self::isExistingMappingPath(), $possibleMappingDirectories);

        return array_flip(reindex(self::namespaceFormatter($baseNamespace), $mappingDirectories));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private static function modulesInPath(string $path): array
    {
        return filter(
            static fn (string $possibleModule): bool => !in_array($possibleModule, ['.', '..'], true),
            scandir($path)
        );
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private static function possibleMappingPaths(string $path): array
    {
        return map(
            static function (mixed $_unused, string $module) use ($path) {
                $mappingsPath = self::MAPPINGS_PATH;

                return realpath("$path/$module/$mappingsPath");
            },
            array_flip(self::modulesInPath($path))
        );
    }

    /**
     * @return callable
     */
    private static function isExistingMappingPath(): callable
    {
        return static fn (string $path): bool => !empty($path);
    }

    /**
     * @param string $baseNamespace
     *
     * @return callable
     */
    private static function namespaceFormatter(string $baseNamespace): callable
    {
        return static fn (string $path): string => "$baseNamespace\\Domain"; //todo check, possible error
    }
}
