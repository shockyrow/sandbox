<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template\Loaders;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\Loaders\DottedFilesystemLoader;
use Shockyrow\Sandbox\Template\Loaders\FilesystemLoader;

final class DottedFilesystemLoaderTest extends TestCase
{
    private const MISSING_FILE_NAME = 'missing_template';
    private const EXAMPLE_TEMPLATE = '<button></button>';
    private const EXAMPLE_EXTENSION = 'example';

    /**
     * @var MockObject|FilesystemLoader
     */
    private $mocked_filesystem_loader;
    private DottedFilesystemLoader $loader;

    protected function setUp(): void
    {
        $this->mocked_filesystem_loader = $this->createMock(FilesystemLoader::class);
        $this->loader = new DottedFilesystemLoader($this->mocked_filesystem_loader, self::EXAMPLE_EXTENSION);
    }

    public static function provideTestLoad(): array
    {
        return [
            [
                ['template'],
            ],
            [
                ['folder', 'template'],
            ],
            [
                ['folder1', 'folder2', 'template'],
            ],
        ];
    }

    /**
     * @dataProvider provideTestLoad
     * @param string[] $parts
     * @return void
     */
    public function testLoad(array $parts): void
    {
        $this
            ->mocked_filesystem_loader
            ->expects($this->once())
            ->method('load')
            ->with(implode(DIRECTORY_SEPARATOR, $parts) . '.' . self::EXAMPLE_EXTENSION)
            ->willReturn(self::EXAMPLE_TEMPLATE);

        self::assertEquals(
            self::EXAMPLE_TEMPLATE,
            $this->loader->load(
                implode('.', $parts)
            )
        );
    }

    /**
     * @dataProvider provideTestLoad
     * @param string[] $parts
     * @return void
     */
    public function testExistsReturnsTrueIfFileExists(array $parts): void
    {
        $this
            ->mocked_filesystem_loader
            ->expects($this->once())
            ->method('exists')
            ->with(implode(DIRECTORY_SEPARATOR, $parts) . '.' . self::EXAMPLE_EXTENSION)
            ->willReturn(true);

        self::assertTrue(
            $this->loader->exists(implode('.', $parts))
        );
    }

    public function testExistsReturnsFalseIfFileDoesNotExist(): void
    {
        $this
            ->mocked_filesystem_loader
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        self::assertFalse(
            $this->loader->exists(self::MISSING_FILE_NAME)
        );
    }
}
