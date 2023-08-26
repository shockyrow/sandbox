<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template\Renderers;

use Shockyrow\Sandbox\Template\Source;
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

    public function render(Template $template): string
    {
        $result = array_reduce(
            $this->renderers,
            function (Template $template, RendererInterface $renderer): Template {
                $code = $renderer->render($template);

                return new Template(
                    new Source($template->getSource()->getName(), $code),
                    $template->getData()
                );
            },
            $template
        );

        return $result->getSource()->getCode();
    }
}
