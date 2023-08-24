<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

use Shockyrow\Sandbox\Enums\SecurityType;

class SimpleSecurity implements SecurityInterface
{
    private string $type;

    public function __construct(string $type = SecurityType::CONSENT)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
