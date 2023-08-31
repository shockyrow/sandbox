<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template;

class DataManager
{
    /**
     * @var mixed|null
     */
    private $data;

    public function __construct()
    {
        $this->data = null;
    }

    /**
     * @return $this
     */
    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return array_reduce(
            explode('.', $key),
            function ($carry, string $key) use ($default) {
                if (is_array($carry)) {
                    return $carry[$key] ?? $default;
                }

                return $default;
            },
            $this->data
        );
    }
}
