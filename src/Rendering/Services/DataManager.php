<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Services;

class DataManager
{
    /**
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($data, string $key, $default = null)
    {
        return array_reduce(
            explode('.', $key),
            function ($carry, string $key) use ($default) {
                if (is_array($carry)) {
                    return $carry[$key] ?? $default;
                }

                return $default;
            },
            $data
        );
    }
}
