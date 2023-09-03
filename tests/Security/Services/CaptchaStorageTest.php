<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Services;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Services\CaptchaStorage;

final class CaptchaStorageTest extends TestCase
{
    private CaptchaStorage $captcha_storage;

    protected function setUp(): void
    {
        $this->captcha_storage = new CaptchaStorage();
    }

    public function testRetrieve(): void
    {
        self::assertEquals(
            'captcha',
            $this->captcha_storage->retrieve()
        );
    }
}
