<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security;

use Shockyrow\Sandbox\Entities\SecurityInterface;

final class DefaultSecurityChecker implements SecurityCheckerInterface
{
    /**
     * @var SecurityCheckerInterface[]
     */
    private array $security_checkers;

    /**
     * @param SecurityCheckerInterface[] $security_checkers
     */
    public function __construct(array $security_checkers)
    {
        $this->security_checkers = $security_checkers;
    }

    public function check(SecurityInterface $security, string $value): bool
    {
        foreach ($this->security_checkers as $security_checker) {
            if ($security_checker->check($security, $value)) {
                return true;
            }
        }

        return false;
    }
}
