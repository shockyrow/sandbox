<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

use ReflectionFunction;

class Act
{
    private string $name;
    private ReflectionFunction $function;

    public function __construct(string $name, ReflectionFunction $function)
    {
        $this->name = $name;
        $this->function = $function;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFunction(): ReflectionFunction
    {
        return $this->function;
    }
}
