<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security;

use Shockyrow\Sandbox\Entities\PasswordSecurity;
use Shockyrow\Sandbox\Entities\SecurityInterface;

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
