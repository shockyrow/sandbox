<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template\Loaders;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\Loaders\FilesystemLoader;

final class FilesystemLoaderTest extends TestCase
{
    private const TOTAL_FILES = 10;
    private const MISSING_FILE_NAME = 'missing_template';
    private const FILENAME_PREFIX = 'template';
    private const DIRECTORIES = [
        'folder1',
        'folder2',
    ];
    private const EXAMPLE_TEMPLATE = '<button></button>';

    /**
     * @var string[]
     */
    private array $filenames;
    private FilesystemLoader $loader;

    protected function setUp(): void
    {
        $this->filenames = [];
        $this->loader = new FilesystemLoader(__DIR__);

        foreach (self::DIRECTORIES as $directory) {
            mkdir($this->resolvePath($directory));

            for ($index = 0; $index < self::TOTAL_FILES; $index++) {
                $filename = $directory . DIRECTORY_SEPARATOR . self::FILENAME_PREFIX . $index;
                $this->filenames[] = $filename;

                file_put_contents(
                    $this->resolvePath($filename),
                    self::EXAMPLE_TEMPLATE
                );
            }
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->filenames as $filename) {
            unlink($this->resolvePath($filename));
        }

        foreach (self::DIRECTORIES as $directory) {
            rmdir($this->resolvePath($directory));
        }
    }

    public function testLoad(): void
    {
        foreach ($this->filenames as $filename) {
            self::assertEquals(self::EXAMPLE_TEMPLATE, $this->loader->load($filename));
        }

        self::assertEquals('', $this->loader->load(self::MISSING_FILE_NAME));
    }

    public function testExists(): void
    {
        foreach ($this->filenames as $filename) {
            self::assertTrue($this->loader->exists($filename));
        }

        self::assertFalse($this->loader->exists(self::MISSING_FILE_NAME));
    }

    private function resolvePath(string $name): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . $name;
    }
}
