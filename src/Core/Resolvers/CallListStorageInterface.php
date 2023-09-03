<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Resolvers;

use Shockyrow\Sandbox\Core\Entities\CallList;

interface CallListStorageInterface
{
    public function save(CallList $call_list): void;

    public function load(): CallList;
}
