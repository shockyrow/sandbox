<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use ReflectionException;
use Shockyrow\Sandbox\Entities\Act;
use Shockyrow\Sandbox\Entities\ActList;
use Shockyrow\Sandbox\Entities\Call;
use Shockyrow\Sandbox\Services\CallListResolvers\CallListStorageInterface;
use Shockyrow\Sandbox\Services\CallRequestHandler;

class App
{
    private EngineInterface $default_engine;
    private CallListStorageInterface $default_call_list_storage;
    private CallRequestHandler $call_request_handler;
    private string $server_api;
    /**
     * @var EngineInterface[]
     */
    private array $engines;
    /**
     * @var CallListStorageInterface[]
     */
    private array $call_list_storages;

    public function __construct(
        EngineInterface $default_engine,
        CallListStorageInterface $default_call_list_storage,
        CallRequestHandler $call_request_handler
    ) {
        $this->default_engine = $default_engine;
        $this->default_call_list_storage = $default_call_list_storage;
        $this->call_request_handler = $call_request_handler;
        $this->server_api = PHP_SAPI;
        $this->engines = [];
        $this->call_list_storages = [];
    }

    /**
     * @return $this
     */
    public function forceServerApi(string $server_api): self
    {
        $this->server_api = $server_api;

        return $this;
    }

    /**
     * @return $this
     */
    public function setEngine(string $interface, EngineInterface $engine): self
    {
        $this->engines[$interface] = $engine;

        return $this;
    }

    /**
     * @return $this
     */
    public function setCallListStorage(string $interface, CallListStorageInterface $call_list_storage): self
    {
        $this->call_list_storages[$interface] = $call_list_storage;

        return $this;
    }

    public function run(array $raw_acts): void
    {
        $engine = $this->resolveEngine();
        $call_list_storage = $this->resolveCallListStorage();
        $act_list = $this->buildActList($raw_acts);
        $call_list = $call_list_storage->load();

        foreach ($call_list->getAll() as $call) {
            $call->removeTag(Call::TAG_NEW);
        }

        $call_request = $engine->getCallRequest($act_list);

        if ($call_request !== null) {
            $call = $this->call_request_handler->handle($call_request);
            $call_list->add($call);
            $call_list_storage->save($call_list);
        }

        $engine->run($act_list, $call_list);
    }

    private function resolveEngine(): EngineInterface
    {
        return $this->engines[$this->server_api] ?? $this->default_engine;
    }

    private function resolveCallListStorage(): CallListStorageInterface
    {
        return $this->call_list_storages[$this->server_api] ?? $this->default_call_list_storage;
    }

    private function buildActList(array $raw_acts): ActList
    {
        $act_list = new ActList();

        foreach ($raw_acts as $key => $raw_act) {
            try {
                $act_list->add(Act::create((string)$key, $raw_act));
            } catch (ReflectionException $exception) {
                continue;
            }
        }

        return $act_list;
    }
}
