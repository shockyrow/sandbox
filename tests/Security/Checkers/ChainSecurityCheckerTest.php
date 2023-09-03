<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Security\Checkers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Security\Checkers\ChainSecurityChecker;
use Shockyrow\Sandbox\Security\Checkers\SecurityCheckerInterface;
use Shockyrow\Sandbox\Security\Entities\SimpleSecurity;

final class ChainSecurityCheckerTest extends TestCase
{
    private const TOTAL_SECURITY_CHECKERS = 10;

    /**
     * @var MockObject[]|SecurityCheckerInterface[]
     */
    private array $mocked_security_checkers;
    private ChainSecurityChecker $chain_security_checker;

    protected function setUp(): void
    {
        $this->mocked_security_checkers = [];

        foreach (range(1, self::TOTAL_SECURITY_CHECKERS) as $ignored) {
            $this->mocked_security_checkers[] = $this->createMock(SecurityCheckerInterface::class);
        }

        $this->chain_security_checker = new ChainSecurityChecker($this->mocked_security_checkers);
    }

    public function testCheck(): void
    {
        $last_security_checker = array_pop($this->mocked_security_checkers);

        foreach ($this->mocked_security_checkers as $mocked_security_checker) {
            $mocked_security_checker
                ->expects(new InvokedCount(2))
                ->method('check')
                ->willReturn(false);
        }

        $last_security_checker
            ->expects(new InvokedCount(2))
            ->method('check')
            ->willReturnOnConsecutiveCalls(false, true);

        self::assertFalse(
            $this->chain_security_checker->check(
                new SimpleSecurity(),
                ''
            )
        );
        self::assertTrue(
            $this->chain_security_checker->check(
                new SimpleSecurity(),
                ''
            )
        );
    }
}
