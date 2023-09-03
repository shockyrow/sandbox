<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Services;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Services\CaptchaManager;

final class CaptchaStorageTest extends TestCase
{
    private const EXAMPLE_CAPTCHA = 'example_captcha';

    private CaptchaManager $captcha_manager;

    protected function setUp(): void
    {
        $this->captcha_manager = new CaptchaManager(self::EXAMPLE_CAPTCHA);
    }

    public function testGetCaptcha(): void
    {
        self::assertEquals(
            self::EXAMPLE_CAPTCHA,
            $this->captcha_manager->getCaptcha()
        );
    }

    public function testRefresh(): void
    {
        $captcha = $this->captcha_manager->getCaptcha();

        $this->captcha_manager->refresh();

        self::assertNotEquals($captcha, $this->captcha_manager->getCaptcha());
    }
}
