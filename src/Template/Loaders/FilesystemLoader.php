<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

class FilesystemLoader implements LoaderInterface
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
        $contents = $this->loadCached($name);

        if ($contents !== null) {
            return $contents;
        }

        $contents = '';
        $filepath = $this->getFilepath($name);

        if (file_exists($filepath)) {
            $contents = file_get_contents($filepath) ?: '';
        }

        $this->cache[$name] = $contents;

        return $contents;
    }

    public function exists(string $name): bool
    {
        if ($this->existsInCache($name)) {
            return true;
        }

        return file_exists($this->getFilepath($name));
    }

    private function loadCached(string $name): ?string
    {
        return $this->cache[$name] ?? null;
    }

    private function existsInCache(string $name): bool
    {
        return $this->loadCached($name) !== null;
    }

    private function getFilepath(string $name): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $name;
    }
}
