<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Renderers;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Entities\Template;
use Shockyrow\Sandbox\Rendering\Renderers\LoopRenderer;
use Shockyrow\Sandbox\Rendering\Renderers\VariableRenderer;
use Shockyrow\Sandbox\Rendering\Services\DataManager;

final class LoopRendererTest extends TestCase
{
    private LoopRenderer $loop_renderer;

    protected function setUp(): void
    {
        $data_manager = new DataManager();
        $this->loop_renderer = new LoopRenderer(
            $data_manager,
            new VariableRenderer($data_manager)
        );
    }

    public static function provideTestRender(): array
    {
        return [
            'Simple loop test' => [
                <<<HTML
<ul>
    @foreach (items as item)
    <li>{{ item }}</li>
    @endforeach
</ul>
HTML,
                [
                    'items' => ['one', 'two', 'three'],
                ],
                <<<HTML
<ul>
    <li>one</li>
    <li>two</li>
    <li>three</li>
</ul>
HTML,
            ],
            'Multiple loop test' => [
                <<<HTML
<ul>
    @foreach (items as item)
    <li>{{ item }}</li>
    @endforeach
</ul>
<hr>
<ul>
    @foreach (items as item)
    <li>{{ item }}</li>
    @endforeach
</ul>
HTML,
                [
                    'items' => ['one', 'two', 'three'],
                ],
                <<<HTML
<ul>
    <li>one</li>
    <li>two</li>
    <li>three</li>
</ul>
<hr>
<ul>
    <li>one</li>
    <li>two</li>
    <li>three</li>
</ul>
HTML,
            ],
        ];
    }

    /**
     * @dataProvider provideTestRender
     */
    public function testRender(string $template, array $data, string $expected_result): void
    {
        $rendered_template = $this->loop_renderer->render(
            new Template(
                new Source('', $template),
                $data
            )
        );

        self::assertEquals(
            $expected_result,
            $rendered_template->getSource()->getCode()
        );
    }
}
