<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use Shockyrow\Sandbox\Entities\ActList;
use Shockyrow\Sandbox\Entities\CallList;
use Shockyrow\Sandbox\Entities\CallRequest;

interface EngineInterface
{
    public function getCallRequest(ActList $act_list): ?CallRequest;

    public function run(ActList $act_list, CallList $call_list): void;
}
