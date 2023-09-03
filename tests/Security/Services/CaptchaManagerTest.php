<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Services;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Services\CaptchaManager;

final class CaptchaManagerTest extends TestCase
{
    private CaptchaManager $captcha_manager;

    protected function setUp(): void
    {
        $this->captcha_manager = new CaptchaManager();
    }

    public function testRefresh(): void
    {
        $first_captcha = $this->captcha_manager->getCaptcha();

        $this->captcha_manager->refresh();

        self::assertNotEquals($first_captcha, $this->captcha_manager->getCaptcha());
    }
}
