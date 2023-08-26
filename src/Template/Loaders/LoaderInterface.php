<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Loaders;

interface LoaderInterface
{
    public function load(string $name): string;

    public function exists(string $name): bool;
}
