<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template\Loaders;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\Loaders\ArrayLoader;
use Shockyrow\Sandbox\Template\Loaders\LoaderInterface;

final class ArrayLoaderTest extends TestCase
{
    private const TEMPLATES = [
        'ol' => '<ol></ol>',
        'li' => '<li></li>',
    ];

    private LoaderInterface $loader;

    protected function setUp(): void
    {
        $this->loader = new ArrayLoader(self::TEMPLATES);
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
    public function testLoad(string $name, string $expected_result): void
    {
        self::assertEquals($expected_result, $this->loader->load($name));
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
