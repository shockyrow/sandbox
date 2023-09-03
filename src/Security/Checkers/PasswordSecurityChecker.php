<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Checkers;

use Shockyrow\Sandbox\Security\Entities\PasswordSecurity;
use Shockyrow\Sandbox\Security\Entities\SecurityInterface;

final class PasswordSecurityChecker implements SecurityCheckerInterface
{
    public function check(SecurityInterface $security, string $value): bool
    {
        if (!$security instanceof PasswordSecurity) {
            return false;
        }

        return $security->getPassword() === $value;
    }
}
