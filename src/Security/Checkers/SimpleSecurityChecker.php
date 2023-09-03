<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Checkers;

use Shockyrow\Sandbox\Security\Entities\SecurityInterface;
use Shockyrow\Sandbox\Security\Entities\SimpleSecurity;
use Shockyrow\Sandbox\Security\Enums\SecurityType;
use Shockyrow\Sandbox\Security\Services\CaptchaManager;

final class SimpleSecurityChecker implements SecurityCheckerInterface
{
    private CaptchaManager $captcha_manager;

    public function __construct(CaptchaManager $captcha_storage)
    {
        $this->captcha_manager = $captcha_storage;
    }

    public function check(SecurityInterface $security, string $value): bool
    {
        if (!$security instanceof SimpleSecurity) {
            return false;
        }

        switch ($security->getType()) {
            case SecurityType::NONE:
                return true;
            case SecurityType::CONSENT:
                return in_array(strtolower($value), ['1', 'on', 'yes', 'true'], true);
            case SecurityType::CAPTCHA:
                return $this->captcha_manager->getCaptcha() === $value;
            default:
                return false;
        }
    }
}
