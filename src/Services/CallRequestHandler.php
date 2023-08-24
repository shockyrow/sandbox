<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Services;

use Error;
use Exception;
use Shockyrow\Sandbox\Entities\ActList;
use Shockyrow\Sandbox\Entities\Call;
use Shockyrow\Sandbox\Entities\CallRequest;
use Shockyrow\Sandbox\Enums\CallTag;
use Shockyrow\Sandbox\Security\DefaultSecurityChecker;

final class CallRequestHandler
{
    private DefaultSecurityChecker $security_checker;

    public function __construct(DefaultSecurityChecker $security_checker)
    {
        $this->security_checker = $security_checker;
    }

    public function handle(ActList $act_list, CallRequest $request): Call
    {
        $call = new Call($request, time(), [CallTag::NEW]);
        $act = $act_list->getOneByName($request->getActName());

        if ($act === null) {
            return $call->setException(
                new Exception('Act not found.')
            );
        }

        if (!$this->security_checker->check($act->getSecurity(), $request->getSecurityValue())) {
            return $call->setException(
                new Exception('Security check failed')
            );
        }

        ob_start();

        try {
            $call->setValue(
                $act->getFunction()->invokeArgs(
                    $request->getArguments()
                )
            );
        } catch (Exception $exception) {
            $call->setException($exception);
        } catch (Error $error) {
            $call->setError($error);
        }

        $output = ob_get_clean();

        if (!in_array($output, [false, ''], true)) {
            $call->setOutput($output);
        }

        return $call;
    }
}
