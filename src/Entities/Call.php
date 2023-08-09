<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

use Error;
use Exception;

final class Call
{
    private CallRequest $call_request;
    private $value;
    private ?string $output;
    private ?Exception $exception;
    private ?Error $error;

    public function __construct(CallRequest $call_request)
    {
        $this->call_request = $call_request;
        $this->value = null;
        $this->output = null;
        $this->exception = null;
        $this->error = null;
    }

    public function getCallRequest(): CallRequest
    {
        return $this->call_request;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @param ?string $output
     *
     * @return $this
     */
    public function setOutput(?string $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function getException(): ?Exception
    {
        return $this->exception;
    }

    /**
     * @return $this
     */
    public function setException(Exception $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * @return $this
     */
    public function setError(Error $error): self
    {
        $this->error = $error;

        return $this;
    }
}
