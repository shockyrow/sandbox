<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox;

use Shockyrow\Sandbox\Template\TemplateEngine;

abstract class BaseEngine implements EngineInterface
{
    private TemplateEngine $template_engine;

    public function __construct(TemplateEngine $template_engine)
    {
        $this->template_engine = $template_engine;
    }

    protected function render(string $name, array $data): string
    {
        return $this->template_engine->render($name, $data);
    }
}
