<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Loaders;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Loaders\DottedFilesystemSourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\FilesystemSourceLoader;

final class DottedFilesystemSourceLoaderTest extends TestCase
{
    private const MISSING_FILE_NAME = 'missing_template';
    private const EXAMPLE_TEMPLATE = '<button></button>';
    private const EXAMPLE_EXTENSION = 'example';

    /**
     * @var MockObject|FilesystemSourceLoader
     */
    private $mocked_filesystem_source_loader;
    private DottedFilesystemSourceLoader $loader;

    protected function setUp(): void
    {
        $this->mocked_filesystem_source_loader = $this->createMock(
            FilesystemSourceLoader::class
        );

        $this->loader = new DottedFilesystemSourceLoader(
            $this->mocked_filesystem_source_loader,
            self::EXAMPLE_EXTENSION
        );
    }

    public static function provideTestLoad(): array
    {
        return [
            [['template']],
            [['folder', 'template']],
            [['folder1', 'folder2', 'template']],
        ];
    }

    /**
     * @dataProvider provideTestLoad
     * @param string[] $parts
     */
    public function testLoad(array $parts): void
    {
        $name = implode('.', $parts);

        $this->mocked_filesystem_source_loader
            ->expects($this->once())
            ->method('load')
            ->with(implode(DIRECTORY_SEPARATOR, $parts) . '.' . self::EXAMPLE_EXTENSION)
            ->willReturn(new Source($name, self::EXAMPLE_TEMPLATE));

        self::assertEquals(
            new Source($name, self::EXAMPLE_TEMPLATE),
            $this->loader->load($name)
        );
    }

    /**
     * @dataProvider provideTestLoad
     * @param string[] $parts
     */
    public function testExistsReturnsTrueIfFileExists(array $parts): void
    {
        $this->mocked_filesystem_source_loader
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
        $this->mocked_filesystem_source_loader
            ->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        self::assertFalse(
            $this->loader->exists(self::MISSING_FILE_NAME)
        );
    }
}
