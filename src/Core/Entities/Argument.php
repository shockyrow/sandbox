<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Entities;

final class Argument
{
    private string $name;
    private $raw_value;
    private $value;

    public function __construct(
        string $name,
        $raw_value,
        $value
    ) {
        $this->name = $name;
        $this->raw_value = $raw_value;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRawValue()
    {
        return $this->raw_value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
