<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Loaders;

use Shockyrow\Sandbox\Rendering\Entities\Source;

final class ArraySourceLoader implements SourceLoaderInterface
{
    /**
     * @var Source[]
     */
    private array $sources;

    /**
     * @param Source[] $sources
     */
    public function __construct(array $sources = [])
    {
        $this->sources = $sources;
    }

    public function load(string $name): Source
    {
        foreach ($this->sources as $source) {
            if ($source->getName() === $name) {
                return $source;
            }
        }

        return new Source($name);
    }

    public function exists(string $name): bool
    {
        foreach ($this->sources as $source) {
            if ($source->getName() === $name) {
                return true;
            }
        }

        return false;
    }
}
