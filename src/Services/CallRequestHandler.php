<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Services;

use Error;
use Exception;
use Shockyrow\Sandbox\Entities\Call;
use Shockyrow\Sandbox\Entities\CallRequest;

final class CallRequestHandler
{
    public function handle(CallRequest $request): Call
    {
        $call = new Call($request, time());

        $function = $request->getAct()->getFunction();
        $raw_arguments = $request->getArguments();

        ob_start();

        try {
            $call->setValue($function->invokeArgs($raw_arguments));
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
