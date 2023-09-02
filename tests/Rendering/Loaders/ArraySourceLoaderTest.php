<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Loaders;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Loaders\ArraySourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\SourceLoaderInterface;

final class ArraySourceLoaderTest extends TestCase
{
    private SourceLoaderInterface $loader;

    protected function setUp(): void
    {
        $this->loader = new ArraySourceLoader([
            new Source('ol', '<ol></ol>'),
            new Source('li', '<li></li>'),
        ]);
    }

    public static function provideTestLoad(): array
    {
        return [
            ['ol', '<ol></ol>'],
            ['li', '<li></li>'],
            ['ul', ''],
        ];
    }

    /**
     * @dataProvider provideTestLoad
     */
    public function testLoad(string $name, string $code): void
    {
        self::assertEquals(
            new Source($name, $code),
            $this->loader->load($name)
        );
    }

    public static function provideTestExists(): array
    {
        return [
            ['ol', true],
            ['li', true],
            ['ul', false],
        ];
    }

    /**
     * @dataProvider provideTestExists
     */
    public function testExists(string $name, bool $expected_result): void
    {
        self::assertEquals($expected_result, $this->loader->exists($name));
    }
}
