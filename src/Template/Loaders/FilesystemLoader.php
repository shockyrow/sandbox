<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

class FilesystemLoader implements LoaderInterface
{
    private string $path;

    public function __construct(
        string $path
    ) {
        $this->path = $path;
    }

    public function load(string $name): string
    {
        return file_get_contents($this->getFilepath($name)) ?: '';
    }

    public function exists(string $name): bool
    {
        return file_exists($this->getFilepath($name));
    }

    private function getFilepath(string $name): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $name;
    }
}
