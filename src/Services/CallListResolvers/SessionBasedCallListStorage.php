<?php

namespace Shockyrow\Sandbox\Services\CallListResolvers;

use Shockyrow\Sandbox\Entities\CallList;

class SessionBasedCallListStorage implements CallListStorageInterface
{
    private const KEY = 'call_list';

    public function load(): CallList
    {
        return $_SESSION[self::KEY] ?? new CallList();
    }

    public function save(CallList $call_list): void
    {
        $_SESSION[self::KEY] = $call_list;
    }

    public function isAvailable(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return session_status() === PHP_SESSION_ACTIVE;
    }
}
