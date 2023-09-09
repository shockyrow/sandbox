<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Logging;

final class Logger
{
    private static ?self $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function logMessage(string $message): void
    {
        error_log($message, 4);
    }

    /**
     * @param string[] $messages
     * @return void
     */
    public function logMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $this->logMessage($message);
        }
    }
}
