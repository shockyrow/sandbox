<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

final class ChainLoader implements LoaderInterface
{
    /**
     * @var LoaderInterface[]
     */
    private array $loaders;
    /**
     * @var string[]
     */
    private array $cache;

    /**
     * @param LoaderInterface[] $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = $loaders;
        $this->cache = [];
    }

    public function load(string $name): string
    {
        $content = $this->loadCached($name);

        if ($content !== null) {
            return $content;
        }

        $content = '';

        foreach ($this->loaders as $loader) {
            if ($loader->exists($name)) {
                $content = $loader->load($name);
                break;
            }
        }

        $this->cache[$name] = $content;

        return $content;
    }

    public function exists(string $name): bool
    {
        if ($this->existsInCache($name)) {
            return true;
        }

        foreach ($this->loaders as $loader) {
            if ($loader->exists($name)) {
                return true;
            }
        }

        return false;
    }

    private function loadCached(string $name): ?string
    {
        return $this->cache[$name] ?? null;
    }

    private function existsInCache(string $name): bool
    {
        return $this->loadCached($name) !== null;
    }
}
