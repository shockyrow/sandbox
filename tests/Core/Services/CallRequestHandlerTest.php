<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Core\Services;

use Error;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Core\Entities\Act;
use Shockyrow\Sandbox\Core\Entities\ActList;
use Shockyrow\Sandbox\Core\Entities\Call;
use Shockyrow\Sandbox\Core\Entities\CallRequest;
use Shockyrow\Sandbox\Core\Enums\CallTag;
use Shockyrow\Sandbox\Core\Services\CallRequestHandler;
use Shockyrow\Sandbox\Security\Checkers\SecurityCheckerInterface;

/**
 * @codeCoverageIgnore
 */
final class CallRequestHandlerTest extends TestCase
{
    private const EXAMPLE_ACT_NAME = 'example_act_name';
    private const EXAMPLE_VALUE = 'example_value';

    /**
     * @var MockObject|SecurityCheckerInterface
     */
    private $mocked_security_checker;
    private CallRequestHandler $call_request_handler;

    protected function setUp(): void
    {
        $this->mocked_security_checker = $this->createMock(SecurityCheckerInterface::class);
        $this->call_request_handler = new CallRequestHandler($this->mocked_security_checker);
    }

    public static function provideTestHandle(): array
    {
        $call_request = new CallRequest(self::EXAMPLE_ACT_NAME, [self::EXAMPLE_VALUE]);
        $closure = function ($value) {
            echo $value;
            return $value;
        };

        return [
            [
                Act::create('', $closure),
                $call_request,
                false,
                (new Call($call_request, 0, [CallTag::NEW]))
                    ->setException(new Exception('Act not found')),
            ],
            [
                Act::create(self::EXAMPLE_ACT_NAME, $closure),
                $call_request,
                false,
                (new Call($call_request, 0, [CallTag::NEW]))
                    ->setException(new Exception('Security check failed')),
            ],
            [
                Act::create(self::EXAMPLE_ACT_NAME, $closure),
                $call_request,
                true,
                (new Call($call_request, 0, [CallTag::NEW]))
                    ->setValue(self::EXAMPLE_VALUE)
                    ->setOutput(self::EXAMPLE_VALUE),
            ],
            [
                Act::create(self::EXAMPLE_ACT_NAME, function ($value) {
                    throw new Exception($value);
                }),
                $call_request,
                true,
                (new Call($call_request, 0, [CallTag::NEW]))
                    ->setException(new Exception(self::EXAMPLE_VALUE)),
            ],
            [
                Act::create(self::EXAMPLE_ACT_NAME, function ($value) {
                    throw new Error($value);
                }),
                $call_request,
                true,
                (new Call($call_request, 0, [CallTag::NEW]))
                    ->setError(new Error(self::EXAMPLE_VALUE)),
            ],
        ];
    }

    /**
     * @dataProvider provideTestHandle
     */
    public function testHandle(Act $act, CallRequest $call_request, bool $security_check_result, Call $call): void
    {
        $act_list = (new ActList())->add($act);

        if ($act->getName() === $call_request->getActName()) {
            $this->mocked_security_checker
                ->expects($this->once())
                ->method('check')
                ->with($act->getSecurity())
                ->willReturn($security_check_result);
        }

        $resulting_call = $this->call_request_handler->handle(
            $act_list,
            $call_request
        );

        self::assertEquals($call->hasError(), $resulting_call->hasError());

        if ($call->hasError()) {
            self::assertEquals(
                $call->getError()->getMessage(),
                $resulting_call->getError()->getMessage()
            );
            self::assertEquals(
                $call->getError()->getCode(),
                $resulting_call->getError()->getCode()
            );
        }

        self::assertEquals($call->hasException(), $resulting_call->hasException());

        if ($call->hasException()) {
            self::assertEquals(
                $call->getException()->getMessage(),
                $resulting_call->getException()->getMessage()
            );
            self::assertEquals(
                $call->getException()->getCode(),
                $resulting_call->getException()->getCode()
            );
        }

        self::assertEquals($call->hasOutput(), $resulting_call->hasOutput());
        self::assertEquals($call->getTags(), $resulting_call->getTags());
        self::assertEquals($call->getValue(), $resulting_call->getValue());
        self::assertEquals($call->getOutput(), $resulting_call->getOutput());
        self::assertEquals($call->getRequest(), $resulting_call->getRequest());
    }
}
