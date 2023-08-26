<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

final class FilesystemLoader implements LoaderInterface
{
    private string $path;
    /**
     * @var string[]
     */
    private array $cache;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->cache = [];
    }

    public function load(string $name): string
    {
        $content = $this->cache[$name] ?? (file_get_contents($this->getFilepath($name)) ?: '');
        $this->cache[$name] = $content;

        return $content;
    }

    public function exists(string $name): bool
    {
        return $this->cache[$name] ?? file_exists($this->getFilepath($name));
    }

    private function getFilepath(string $name): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $name;
    }
}
