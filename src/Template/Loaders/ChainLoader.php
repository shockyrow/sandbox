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
     * @param LoaderInterface[] $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = $loaders;
    }

    public function load(string $name): string
    {
        foreach ($this->loaders as $loader) {
            if ($loader->exists($name)) {
                return $loader->load($name);
            }
        }

        return '';
    }

    public function exists(string $name): bool
    {
        foreach ($this->loaders as $loader) {
            if ($loader->exists($name)) {
                return true;
            }
        }

        return false;
    }
}
