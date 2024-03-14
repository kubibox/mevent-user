<?php

declare(strict_types=1);

namespace App\Application\Shared\Domain\Infrastructure\Doctrine;

final class DoctrinePrefixesSearcher
{
    private const MAPPINGS_PATH = 'Infrastructure/Persistence/Doctrine';

    /**
     * @param string $path
     * @param string $baseNamespace
     *
     * @return array
     */
    public static function inPath(string $path, string $baseNamespace): array
    {
        $possibleMappingDirectories = self::possibleMappingPaths($path);

        $mappingDirectories = array_filter(
            $possibleMappingDirectories,
            self::isExistingMappingPath(),
            ARRAY_FILTER_USE_KEY
        );

        return array_flip(array_values(self::reindexDir($baseNamespace, $mappingDirectories)));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private static function modulesInPath(string $path): array
    {
        return array_values(array_filter(
            scandir($path),
            static fn(string $possibleModule) => !in_array($possibleModule, ['.', '..'], true)
        ));
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private static function possibleMappingPaths(string $path): array
    {
        return array_map(
            static function (string $module) use ($path) {
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
        return static fn(string $path) => !empty($path);
    }

    /**
     * @param string $path
     * @param array $additional
     *
     * @return array
     */
    private static function reindexDir(string $path, array $additional): array
    {
        return array_map(
            static fn(string $dir): string => "$path\\$dir\Domain",
            array_keys($additional)
        );
    }
}
