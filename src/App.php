<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use ReflectionException;
use Shockyrow\Sandbox\Entities\Act;
use Shockyrow\Sandbox\Entities\ActList;
use Shockyrow\Sandbox\Entities\CallList;
use Shockyrow\Sandbox\Services\CallRequestHandler;

class App
{
    private EngineInterface $default_engine;
    private CallRequestHandler $call_request_handler;
    /**
     * @var EngineInterface[]
     */
    private array $engines;

    public function __construct(
        EngineInterface $default_engine,
        CallRequestHandler $call_request_handler
    ) {
        $this->default_engine = $default_engine;
        $this->call_request_handler = $call_request_handler;
        $this->engines = [];
    }

    public function run(array $raw_acts): void
    {
        $engine = $this->resolveEngine();
        $act_list = $this->resolveActList($raw_acts);
        $call_list = new CallList();

        $call_request = $engine->run($act_list);

        if ($call_request !== null) {
            $call_list->add(
                $this->call_request_handler->handle($call_request)
            );
        }
    }

    /**
     * @return $this
     */
    public function setEngine(string $interface, EngineInterface $engine): self
    {
        $this->engines[$interface] = $engine;

        return $this;
    }

    private function resolveEngine(): EngineInterface
    {
        return $this->engines[PHP_SAPI] ?? $this->default_engine;
    }

    private function resolveActList(array $raw_acts): ActList
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
