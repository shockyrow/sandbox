<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use Shockyrow\Sandbox\Template\RenderingService;

abstract class BaseEngine implements EngineInterface
{
    private RenderingService $rendering_service;

    public function __construct(RenderingService $rendering_service)
    {
        $this->rendering_service = $rendering_service;
    }

    protected function render(string $name, array $data): string
    {
        return $this->rendering_service->render($name, $data);
    }
}
