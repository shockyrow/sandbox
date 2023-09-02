<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Loaders;

use Shockyrow\Sandbox\Rendering\Entities\Source;

interface SourceLoaderInterface
{
    public function load(string $name): Source;

    public function exists(string $name): bool;
}
