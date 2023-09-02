<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Loaders;

use Shockyrow\Sandbox\Rendering\Entities\Source;

class FilesystemSourceLoader implements SourceLoaderInterface
{
    private string $path;
    /**
     * @var Source[]
     */
    private array $cache;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->cache = [];
    }

    public function load(string $name): Source
    {
        $source = $this->loadCached($name);

        if ($source !== null) {
            return $source;
        }

        $contents = '';
        $filepath = $this->getFilepath($name);

        if (file_exists($filepath)) {
            $contents = file_get_contents($filepath) ?: '';
        }

        $source = new Source($name, $contents);
        $this->cache[$name] = $source;

        return $source;
    }

    public function exists(string $name): bool
    {
        if ($this->existsInCache($name)) {
            return true;
        }

        return file_exists($this->getFilepath($name));
    }

    private function loadCached(string $name): ?Source
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
