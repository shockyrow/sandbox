<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Checkers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Checkers\SimpleSecurityChecker;
use Shockyrow\Sandbox\Security\Entities\PasswordSecurity;
use Shockyrow\Sandbox\Security\Entities\SecurityInterface;
use Shockyrow\Sandbox\Security\Entities\SimpleSecurity;
use Shockyrow\Sandbox\Security\Enums\SecurityType;
use Shockyrow\Sandbox\Security\Services\CaptchaManager;

final class SimpleSecurityCheckerTest extends TestCase
{
    private const EXAMPLE_CAPTCHA = 'example_captcha';

    /**
     * @var MockObject|CaptchaManager
     */
    private $mocked_captcha_storage;
    private SimpleSecurityChecker $simple_security_checker;

    protected function setUp(): void
    {
        $this->mocked_captcha_storage = $this->createMock(CaptchaManager::class);
        $this->simple_security_checker = new SimpleSecurityChecker(
            $this->mocked_captcha_storage
        );
    }

    public static function provideTestCheck(): array
    {
        return [
            [
                new SimpleSecurity(SecurityType::NONE),
                '',
                true,
            ],
            [
                new SimpleSecurity(),
                '',
                false,
            ],
            [
                new SimpleSecurity(),
                '1',
                true,
            ],
            [
                new SimpleSecurity(),
                '0',
                false,
            ],
            [
                new SimpleSecurity(),
                'on',
                true,
            ],
            [
                new SimpleSecurity(),
                'off',
                false,
            ],
            [
                new SimpleSecurity(),
                'yes',
                true,
            ],
            [
                new SimpleSecurity(),
                'no',
                false,
            ],
            [
                new SimpleSecurity(),
                'true',
                true,
            ],
            [
                new SimpleSecurity(),
                'false',
                false,
            ],
            [
                new SimpleSecurity(SecurityType::CAPTCHA),
                '',
                false,
            ],
            [
                new SimpleSecurity(SecurityType::CAPTCHA),
                self::EXAMPLE_CAPTCHA,
                true,
            ],
            [
                new SimpleSecurity(''),
                '',
                false,
            ],
        ];
    }

    /**
     * @dataProvider provideTestCheck
     */
    public function testCheck(
        SecurityInterface $security,
        string $value,
        bool $expected_result
    ): void {
        if ($security->getType() === SecurityType::CAPTCHA) {
            $this->mocked_captcha_storage
                ->expects($this->once())
                ->method('getCaptcha')
                ->willReturn(self::EXAMPLE_CAPTCHA);
        }

        self::assertEquals(
            $expected_result,
            $this->simple_security_checker->check($security, $value)
        );
    }
}
