<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Entities;

final class CallRequest
{
    private string $act_name;
    /**
     * @var string[]
     */
    private array $arguments;
    private string $security_value;

    /**
     * @param string[] $arguments
     */
    public function __construct(
        string $act_name,
        array $arguments,
        string $security_value = ''
    ) {
        $this->act_name = $act_name;
        $this->arguments = $arguments;
        $this->security_value = $security_value;
    }

    public function getActName(): string
    {
        return $this->act_name;
    }

    /**
     * @return string[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getSecurityValue(): string
    {
        return $this->security_value;
    }
}
