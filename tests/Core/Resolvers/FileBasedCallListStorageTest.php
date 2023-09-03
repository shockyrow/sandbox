<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Core\Resolvers;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Core\Entities\Call;
use Shockyrow\Sandbox\Core\Entities\CallList;
use Shockyrow\Sandbox\Core\Entities\CallRequest;
use Shockyrow\Sandbox\Core\Resolvers\FileBasedCallListStorage;

final class FileBasedCallListStorageTest extends TestCase
{
    private string $filepath;
    private FileBasedCallListStorage $storage;
    private CallList $call_list;

    protected function setUp(): void
    {
        $this->filepath = tempnam(__DIR__, 'call_list');
        $this->storage = new FileBasedCallListStorage($this->filepath);
        $this->call_list = (new CallList())->add(
            new Call(new CallRequest('', []), 0)
        );
    }

    public function testSave(): void
    {
        $this->storage->save($this->call_list);

        self::assertEquals(
            serialize($this->call_list),
            file_get_contents($this->filepath)
        );
    }

    public function testLoad(): void
    {
        file_put_contents($this->filepath, serialize($this->call_list));

        self::assertEquals(
            $this->call_list,
            $this->storage->load()
        );
    }

    protected function tearDown(): void
    {
        unlink($this->filepath);
    }
}
