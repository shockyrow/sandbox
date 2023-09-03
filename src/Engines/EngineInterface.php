<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Engines;

use Shockyrow\Sandbox\Core\Entities\ActList;
use Shockyrow\Sandbox\Core\Entities\CallList;
use Shockyrow\Sandbox\Core\Entities\CallRequest;

interface EngineInterface
{
    public function getCallRequest(ActList $act_list): ?CallRequest;

    public function run(ActList $act_list, CallList $call_list): void;
}
