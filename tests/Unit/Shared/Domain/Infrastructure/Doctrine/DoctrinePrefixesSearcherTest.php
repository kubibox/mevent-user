<?php

declare(strict_types=1);

namespace Unit\Shared\Domain\Infrastructure\Doctrine;

use App\Shared\Domain\Infrastructure\Doctrine\DoctrinePrefixesSearcher;
use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group MustPass
 */
final class DoctrinePrefixesSearcherTest extends TestCase
{
    /**
     * @param string $module
     * @param string $baseNamespace
     * @param array $expected
     *
     * @return void
     * @dataProvider moduleDataProvider
     */
    public function testPathParse(string $module, string $baseNamespace, array $expected): void
    {
        $prefix = DoctrinePrefixesSearcher::inPath(SRC_DIR . 'Register', 'App\\Register');

        self::assertPrefix($prefix, $expected);
    }

    private static function assertPrefix(array $prefix, array $expected): void
    {
        if (empty($expected)) {
            self::assertEmpty($prefix);
            return;
        }

        self::assertSame(array_keys($expected), array_keys($prefix));

        self::assertSame(array_values($expected)[0], array_values($prefix)[0]);
    }

    private static function assertDirs(array $expected, array $actual): void
    {
        self::assertSame(array_values($actual[0]), array_values($expected[0]));
    }

    public function moduleDataProvider(): \Generator
    {
        yield 'when exist module' => [
            'module' => 'Register',
            'baseNamespace' => 'App\\Register',
            'expected' => [
                SRC_DIR . 'Register/Infrastructure/Persistence/Doctrine' => 'App\Register\Domain'
            ],
        ];
    }
}
