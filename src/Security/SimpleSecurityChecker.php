<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security;

use Shockyrow\Sandbox\Entities\SecurityInterface;
use Shockyrow\Sandbox\Entities\SimpleSecurity;
use Shockyrow\Sandbox\Enums\SecurityType;
use Shockyrow\Sandbox\Services\CaptchaStorage;

final class SimpleSecurityChecker implements SecurityCheckerInterface
{
    private CaptchaStorage $captcha_storage;

    public function __construct(CaptchaStorage $captcha_storage)
    {
        $this->captcha_storage = $captcha_storage;
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
                return $this->captcha_storage->retrieve() === $value;
            default:
                return false;
        }
    }
}
