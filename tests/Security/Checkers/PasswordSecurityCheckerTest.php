<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Checkers;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Checkers\PasswordSecurityChecker;
use Shockyrow\Sandbox\Security\Entities\PasswordSecurity;
use Shockyrow\Sandbox\Security\Entities\SecurityInterface;
use Shockyrow\Sandbox\Security\Entities\SimpleSecurity;

final class PasswordSecurityCheckerTest extends TestCase
{
    private const EXAMPLE_PASSWORD = 'password';

    private PasswordSecurityChecker $password_security_checker;

    protected function setUp(): void
    {
        $this->password_security_checker = new PasswordSecurityChecker();
    }

    public static function provideTestCheck(): array
    {
        return [
            [
                new SimpleSecurity(),
                self::EXAMPLE_PASSWORD,
                false,
            ],
            [
                new PasswordSecurity(''),
                self::EXAMPLE_PASSWORD,
                false,
            ],
            [
                new PasswordSecurity(self::EXAMPLE_PASSWORD),
                self::EXAMPLE_PASSWORD,
                true,
            ],
        ];
    }

    /**
     * @dataProvider provideTestCheck
     */
    public function testCheck(
        SecurityInterface $security,
        string $password,
        bool $expected_result
    ): void {
        self::assertEquals(
            $expected_result,
            $this->password_security_checker->check($security, $password)
        );
    }
}
