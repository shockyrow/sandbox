<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Loaders;

use Shockyrow\Sandbox\Rendering\Entities\Source;

final class ChainSourceLoader implements SourceLoaderInterface
{
    /**
     * @var SourceLoaderInterface[]
     */
    private array $loaders;
    /**
     * @var Source[]
     */
    private array $cache;

    /**
     * @param SourceLoaderInterface[] $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = $loaders;
        $this->cache = [];
    }

    public function load(string $name): Source
    {
        $source = $this->loadCached($name);

        if ($source !== null) {
            return $source;
        }

        $source = '';

        foreach ($this->loaders as $loader) {
            if ($loader->exists($name)) {
                $source = $loader->load($name);
                break;
            }
        }

        $this->cache[$name] = $source;

        return $source;
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

    private function loadCached(string $name): ?Source
    {
        return $this->cache[$name] ?? null;
    }

    private function existsInCache(string $name): bool
    {
        return $this->loadCached($name) !== null;
    }
}
