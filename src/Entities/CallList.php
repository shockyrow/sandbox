<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class CallList
{
    /**
     * @var Call[]
     */
    private array $calls;

    public function __construct()
    {
        $this->calls = [];
    }

    /**
     * @return Call[]
     */
    public function getAll(): array
    {
        return $this->calls;
    }

    /**
     * @return $this
     */
    public function add(Call $call): self
    {
        $this->calls[] = $call;

        return $this;
    }
}
