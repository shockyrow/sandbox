<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Services;

use Shockyrow\Sandbox\Entities\Call;
use Shockyrow\Sandbox\Entities\CallRequest;

final class CallRequestHandler
{
    public function handle(CallRequest $call_request): Call
    {
        return new Call($call_request);
    }
}
