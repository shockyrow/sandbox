<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Resolvers;

use Shockyrow\Sandbox\Core\Entities\CallList;

final class FileBasedCallListStorage implements CallListStorageInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function save(CallList $call_list): void
    {
        if ($this->isFileAvailable()) {
            file_put_contents($this->filename, serialize($call_list));
        }
    }

    public function load(): CallList
    {
        if ($this->isFileAvailable()) {
            $contents = file_get_contents($this->filename) ?: '';
            $result = unserialize($contents);

            if ($result instanceof CallList) {
                return $result;
            }
        }

        return new CallList();
    }

    private function isFileAvailable(): bool
    {
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, '');
        }

        return file_exists($this->filename);
    }
}
