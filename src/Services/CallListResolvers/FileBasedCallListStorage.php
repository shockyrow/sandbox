<?php

namespace Shockyrow\Sandbox\Services\CallListResolvers;

use Shockyrow\Sandbox\Entities\CallList;

class FileBasedCallListStorage implements CallListStorageInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function load(): CallList
    {
        $contents = file_get_contents($this->filename) ?: '';
        $result = unserialize($contents);

        if ($result instanceof CallList) {
            return $result;
        }

        return new CallList();
    }

    public function save(CallList $call_list): void
    {
        file_put_contents($this->filename, serialize($call_list));
    }

    public function isAvailable(): bool
    {
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, '');
        }

        return file_exists($this->filename);
    }
}
