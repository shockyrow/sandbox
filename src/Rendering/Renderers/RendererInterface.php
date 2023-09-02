<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Renderers;

use Shockyrow\Sandbox\Rendering\Entities\Template;

interface RendererInterface
{
    public function render(Template $template): Template;
}
