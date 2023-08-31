<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Renderers;

use Shockyrow\Sandbox\Template\Template;

interface RendererInterface
{
    public function render(Template $template): Template;
}
