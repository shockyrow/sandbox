<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use Shockyrow\Sandbox\Entities\ActList;

interface EngineInterface
{
    public function run(ActList $act_list): void;
}
