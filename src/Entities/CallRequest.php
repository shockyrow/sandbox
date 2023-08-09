<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class CallRequest
{
    private Act $act;
    private ArgumentList $argument_list;

    public function __construct(
        Act $act,
        ArgumentList $argument_list
    ) {
        $this->act = $act;
        $this->argument_list = $argument_list;
    }

    public function getAct(): Act
    {
        return $this->act;
    }

    public function getArgumentList(): ArgumentList
    {
        return $this->argument_list;
    }
}
