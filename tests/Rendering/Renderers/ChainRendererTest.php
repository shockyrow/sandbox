<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Renderers;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Entities\Template;
use Shockyrow\Sandbox\Rendering\Renderers\ChainRenderer;
use Shockyrow\Sandbox\Rendering\Renderers\RendererInterface;

final class ChainRendererTest extends TestCase
{
    private const TOTAL_RENDERERS = 10;
    private const EXAMPLE_TEMPLATE = '<button></button>';

    /**
     * @var MockObject[]|RendererInterface[]
     */
    private array $mocked_renderers;
    private ChainRenderer $renderer;

    protected function setUp(): void
    {
        $this->mocked_renderers = [];

        foreach (range(1, self::TOTAL_RENDERERS) as $ignored) {
            $this->mocked_renderers[] = $this->createMock(RendererInterface::class);
        }

        $this->renderer = new ChainRenderer($this->mocked_renderers);
    }

    public function testRender(): void
    {
        $last_renderer = array_pop($this->mocked_renderers);

        foreach ($this->mocked_renderers as $mocked_renderer) {
            $mocked_renderer
                ->expects($this->once())
                ->method('render')
                ->willReturnCallback(fn (Template $template): Template => $template);
        }

        $last_renderer
            ->expects($this->once())
            ->method('render')
            ->willReturn(
                new Template(new Source('', self::EXAMPLE_TEMPLATE), [])
            );

        $template = $this->renderer->render(
            new Template(new Source(''), [])
        );

        self::assertInstanceOf(Template::class, $template);
        self::assertEquals(self::EXAMPLE_TEMPLATE, $template->getSource()->getCode());
    }
}
