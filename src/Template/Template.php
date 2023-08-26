<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template;

final class Template
{
    private Source $source;
    private array $data;

    public function __construct(
        Source $source,
        array $data = []
    ) {
        $this->source = $source;
        $this->data = $data;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return mixed|null
     * @deprecated Find another way/place to do this since this is not healthy
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }
}
