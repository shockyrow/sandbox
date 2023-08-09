<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

use Closure;
use ReflectionException;
use ReflectionFunction;

final class Act
{
    private string $name;
    private ReflectionFunction $function;

    public function __construct(string $name, ReflectionFunction $function)
    {
        $this->name = $name;
        $this->function = $function;
    }

    /**
     * @throws ReflectionException
     */
    public static function create(string $name, $raw_act): self
    {
        if ($raw_act instanceof self) {
            return $raw_act;
        }

        if ($raw_act instanceof Closure) {
            return new self($name, new ReflectionFunction($raw_act));
        }

        if (is_callable($raw_act)) {
            $function = new ReflectionFunction($raw_act);

            return new self($function->getName(), $function);
        }

        return self::create(
            $name,
            function () use ($raw_act) {
                return $raw_act;
            }
        );
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
