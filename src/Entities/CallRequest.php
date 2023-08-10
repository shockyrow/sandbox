<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

final class CallRequest
{
    private Act $act;
    /**
     * @var string[]
     */
    private array $arguments;

    /**
     * @param string[] $arguments
     */
    public function __construct(
        Act $act,
        array $arguments
    ) {
        $this->act = $act;
        $this->arguments = $arguments;
    }

    public function getAct(): Act
    {
        return $this->act;
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
