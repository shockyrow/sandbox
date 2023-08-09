<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class CallList
{
    /**
     * @var Call[]
     */
    private array $calls;
    /**
     * @var Call[]
     */
    private array $act_calls;

    public function __construct()
    {
        $this->calls = [];
        $this->act_calls = [];
    }

    /**
     * @return Call[]
     */
    public function getAll(): array
    {
        return $this->calls;
    }

    /**
     * @return Call[]
     */
    public function getByAct(Act $act): array
    {
        return $this->act_calls[$act->getName()] ?? [];
    }

    /**
     * @return $this
     */
    public function add(Call $call): self
    {
        $this->calls[] = $call;

        $act = $call->getCallRequest()->getAct();
        $this->act_calls[$act->getName()] = $call;

        return $this;
    }
}
