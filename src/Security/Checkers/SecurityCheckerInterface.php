<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Checkers;

use Shockyrow\Sandbox\Security\Entities\SecurityInterface;

interface SecurityCheckerInterface
{
    public function check(SecurityInterface $security, string $value): bool;
}
