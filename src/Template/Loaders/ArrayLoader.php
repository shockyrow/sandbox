<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

final class ArrayLoader implements LoaderInterface
{
    /**
     * @var string[]
     */
    private array $templates;

    /**
     * @param string[] $templates
     */
    public function __construct(
        array $templates = []
    ) {
        $this->templates = $templates;
    }

    public function load(string $name): string
    {
        return $this->templates[$name] ?? '';
    }

    public function exists(string $name): bool
    {
        return isset($this->templates[$name]);
    }
}
