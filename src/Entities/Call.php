<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Entities;

use Error;
use Exception;

final class Call
{
    private CallRequest $request;
    private int $called_at;
    private $value;
    private ?string $output;
    private ?Exception $exception;
    private ?Error $error;

    public function __construct(
        CallRequest $request,
        int $called_at
    ) {
        $this->request = $request;
        $this->called_at = $called_at;
        $this->value = null;
        $this->output = null;
        $this->exception = null;
        $this->error = null;
    }

    public function getRequest(): CallRequest
    {
        return $this->request;
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
