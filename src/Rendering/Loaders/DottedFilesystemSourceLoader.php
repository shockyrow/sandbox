<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Loaders;

use Shockyrow\Sandbox\Rendering\Entities\Source;

final class DottedFilesystemSourceLoader implements SourceLoaderInterface
{
    private const DEFAULT_FILE_EXTENSION = 'html';

    private FilesystemSourceLoader $filesystem_loader;
    private string $file_extension;

    public function __construct(
        FilesystemSourceLoader $filesystem_loader,
        string $file_extension = self::DEFAULT_FILE_EXTENSION
    ) {
        $this->filesystem_loader = $filesystem_loader;
        $this->file_extension = $file_extension;
    }

    public function load(string $name): Source
    {
        return $this->filesystem_loader->load(
            $this->getFilename($name)
        );
    }

    public function exists(string $name): bool
    {
        return $this->filesystem_loader->exists(
            $this->getFilename($name)
        );
    }

    private function getFilename(string $name): string
    {
        $parts = explode('.', $name) ?: [];

        return sprintf(
            "%s.%s",
            implode(DIRECTORY_SEPARATOR, $parts),
            $this->file_extension
        );
    }
}
