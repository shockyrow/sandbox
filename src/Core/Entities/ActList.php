<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Entities;

final class ActList
{
    /**
     * @var Act[]
     */
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

    public function getOneByName(string $name): ?Act
    {
        return $this->acts[$name] ?? null;
    }

    /**
     * @return $this
     */
    public function add(Act $act): self
    {
        $this->acts[$act->getName()] = $act;

        return $this;
    }
}
