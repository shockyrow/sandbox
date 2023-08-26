<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Services\CallListResolvers;

use Shockyrow\Sandbox\Entities\CallList;

final class FileBasedCallListStorage implements CallListStorageInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
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

    public function save(CallList $call_list): void
    {
        if ($this->isFileAvailable()) {
            file_put_contents(
                $this->filename,
                serialize($call_list) // Todo: this is not working because it cannot serialize reflections
            );
        }
    }

    private function isFileAvailable(): bool
    {
        if (!file_exists($this->filename)) {
            file_put_contents($this->filename, '');
        }

        return file_exists($this->filename);
    }
}
