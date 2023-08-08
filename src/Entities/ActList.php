<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class ActList
{
    /** @var Act[] */
    private array $acts;

    public function __construct()
    {
        $this->acts = [];
    }

    /**
     * @return Act[]
     */
    public function getAll(): array
    {
        return $this->acts;
    }

    public function get(string $name): ?Act
    {
        return $this->acts[$name] ?? null;
    }

    public function add(Act $act): self
    {
        $this->acts[$act->getName()] = $act;

        return $this;
    }
}
