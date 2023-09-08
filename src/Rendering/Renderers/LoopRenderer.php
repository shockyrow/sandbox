<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering\Renderers;

use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Entities\Template;
use Shockyrow\Sandbox\Rendering\Services\DataManager;

final class LoopRenderer implements RendererInterface
{
    private DataManager $data_manager;
    private VariableRenderer $variable_renderer;

    public function __construct(
        DataManager $data_manager,
        VariableRenderer $variable_renderer
    ) {
        $this->data_manager = $data_manager;
        $this->variable_renderer = $variable_renderer;
    }

    public function render(Template $template): Template
    {
        $code = (string)preg_replace_callback(
            "/@foreach\s*\((?<list_key>\w+)\s+as\s+((?<item_index>\w+)\s+=>\s+)?(?<item_key>\w+)\)\s*^(?<body>[^@]*?)$\s*@endforeach/m",
            function (array $matches) use($template): string {
                $list_key = $matches['list_key'] ?? '';
                $item_index = $matches['item_index'] ?? 'index';
                $item_key = $matches['item_key'] ?? 'item';
                $body = $matches['body'] ?? 'item';
                $html = '';

                $list = $this->data_manager->get($template->getData(), $list_key, $list_key);

                if ($list === null) {
                    return $html;
                }

                foreach ($list as $index => $item) {
                    $sub_template = new Template(
                        new Source('', $body),
                        [
                            $item_index => $index,
                            $item_key => $item,
                        ]
                    );
                    $rendered_template = $this->variable_renderer->render($sub_template);
                    $html .= $rendered_template->getSource()->getCode() . PHP_EOL;
                }

                return trim($html);
            },
            $template->getSource()->getCode()
        );

        return new Template(
            new Source(
                $template->getSource()->getName(),
                $code
            ),
            $template->getData()
        );
    }
}
