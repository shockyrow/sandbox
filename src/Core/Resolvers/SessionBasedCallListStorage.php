<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Resolvers;

use Shockyrow\Sandbox\Core\Entities\CallList;

final class SessionBasedCallListStorage implements CallListStorageInterface
{
    private const KEY = 'call_list';

    public function save(CallList $call_list): void
    {
        if ($this->isSessionAvailable()) {
            $_SESSION[self::KEY] = $call_list;
        }
    }

    public function load(): CallList
    {
        if ($this->isSessionAvailable()) {
            return $_SESSION[self::KEY] ?? new CallList();
        }

        return new CallList();
    }

    private function isSessionAvailable(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return session_status() === PHP_SESSION_ACTIVE;
    }
}
