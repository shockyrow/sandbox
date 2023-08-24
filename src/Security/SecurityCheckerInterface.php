<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security;

use Shockyrow\Sandbox\Entities\SecurityInterface;

interface SecurityCheckerInterface
{
    public function check(SecurityInterface $security, string $value): bool;
}
