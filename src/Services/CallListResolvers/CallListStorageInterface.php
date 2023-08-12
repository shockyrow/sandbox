<?php

namespace Shockyrow\Sandbox\Services\CallListResolvers;

use Shockyrow\Sandbox\Entities\CallList;

interface CallListStorageInterface
{
    public function load(): CallList;

    public function save(CallList $call_list): void;

    public function isAvailable(): bool;
}
