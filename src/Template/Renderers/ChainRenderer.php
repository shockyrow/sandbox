<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Renderers;

use Shockyrow\Sandbox\Template\Template;

final class ChainRenderer implements RendererInterface
{
    /**
     * @var RendererInterface[]
     */
    private array $renderers;

    /**
     * @param RendererInterface[] $renderers
     */
    public function __construct(array $renderers)
    {
        $this->renderers = $renderers;
    }

    public function render(Template $template): Template
    {
        $result = array_reduce(
            $this->renderers,
            fn (Template $template, RendererInterface $renderer): Template => $renderer->render($template),
            $template
        );

        return $result->getSource()->getCode();
    }
}
