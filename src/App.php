<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use ReflectionException;
use Shockyrow\Sandbox\Entities\Act;
use Shockyrow\Sandbox\Entities\ActList;

class App
{
    private EngineInterface $default_engine;
    /** @var EngineInterface[] */
    private array $engines;

    public function __construct(
        EngineInterface $default_engine
    ) {
        $this->default_engine = $default_engine;
        $this->engines = [];
    }

    public function run(array $raw_acts): void
    {
        $engine = $this->resolveEngine();
        $act_list = $this->resolveActList($raw_acts);

        $engine->run($act_list);
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
