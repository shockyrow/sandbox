<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class ArgumentList
{
    /**
     * @var Argument[]
     */
    private array $arguments;

    public function __construct()
    {
        $this->arguments = [];
    }

    /**
     * @return Argument[]
     */
    public function getAll(): array
    {
        return $this->arguments;
    }

    public function getOneByName(string $name): ?Argument
    {
        return $this->arguments[$name] ?? null;
    }

    /**
     * @return $this
     */
    public function add(Argument $argument): self
    {
        $this->arguments[$argument->getName()] = $argument;

        return $this;
    }
}
