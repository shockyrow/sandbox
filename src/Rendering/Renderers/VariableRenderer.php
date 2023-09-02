<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Renderers;

use Shockyrow\Sandbox\Rendering\DataManager;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Entities\Template;

final class VariableRenderer implements RendererInterface
{
    private DataManager $data_manager;

    public function __construct(DataManager $data_manager)
    {
        $this->data_manager = $data_manager;
    }

    public function render(Template $template): Template
    {
        $this->data_manager->setData($template->getData());

        return new Template(
            new Source(
                $template->getSource()->getName(),
                (string)preg_replace_callback(
                    "/\{{2}\s*([\w.]+)\s*}{2}/",
                    function (array $matches) use ($template): string {
                        [, $key] = $matches;
                        return (string)$this->data_manager->get($key, $key);
                    },
                    $template->getSource()->getCode()
                )
            ),
            $template->getData()
        );
    }
}