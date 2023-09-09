<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Services;

final class RenderingService
{
    private string $views_dir;
    private string $filepath;

    public function __construct(string $views_dir)
    {
        $this->views_dir = $views_dir;
    }

    public function render(string $name, array $data): string
    {
        $this->filepath = $this->views_dir . DIRECTORY_SEPARATOR . $name;

        return $this->extractAndInclude($data);
    }

    private function extractAndInclude(array $data): string
    {
        extract($data);

        ob_start();

        include $this->filepath;

        return ob_get_clean() ?: '';
    }
}
