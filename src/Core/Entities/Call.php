<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Entities;

use Error;
use Exception;

final class Call
{
    private CallRequest $request;
    private int $called_at;
    /**
     * @param string[] $tags
     */
    private array $tags;
    /**
     * @var mixed|null
     */
    private $value;
    private ?string $output;
    private ?Exception $exception;
    private ?Error $error;

    /**
     * @param string[] $tags
     */
    public function __construct(
        CallRequest $request,
        int $called_at,
        array $tags = []
    ) {
        $this->request = $request;
        $this->called_at = $called_at;
        $this->tags = $tags;
        $this->value = null;
        $this->output = null;
        $this->exception = null;
        $this->error = null;
    }

    public function getRequest(): CallRequest
    {
        return $this->request;
    }

    public function getCalledAt(): int
    {
        return $this->called_at;
    }

    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->tags, true);
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return $this
     */
    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;
        $this->tags = array_unique($this->tags);

        return $this;
    }

    /**
     * @return $this
     */
    public function removeTag(string $tag): self
    {
        $tag_key = array_search($tag, $this->tags, true);

        if ($tag_key === false) {
            return $this;
        }

        array_splice($this->tags, $tag_key, 1);

        return $this;
    }

    /**
     * @return mixed|null
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

    public function hasOutput(): bool
    {
        return $this->output !== null;
    }

    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @return $this
     */
    public function setOutput(?string $output): self
    {
        $this->output = $output;

        return $this;
    }

    public function hasException(): bool
    {
        return $this->exception !== null;
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

    public function hasError(): bool
    {
        return $this->error !== null;
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
