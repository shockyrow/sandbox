<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template;

final class Source
{
    private string $name;
    private string $code;

    public function __construct(
        string $name,
        string $code
    ) {
        $this->name = $name;
        $this->code = $code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
