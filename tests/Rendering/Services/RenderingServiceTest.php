<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Services;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Loaders\SourceLoaderInterface;
use Shockyrow\Sandbox\Rendering\Renderers\RendererInterface;
use Shockyrow\Sandbox\Rendering\Services\RenderingService;

final class RenderingServiceTest extends TestCase
{
    private const EXAMPLE_NAME = 'example';
    private const EXAMPLE_CODE = '<button>example</button>';

    /**
     * @var MockObject|SourceLoaderInterface
     */
    private $mocked_source_loader;
    /**
     * @var MockObject|RendererInterface
     */
    private $mocked_renderer;
    private RenderingService $rendering_service;

    public function setUp(): void
    {
        $this->mocked_source_loader = $this->createMock(SourceLoaderInterface::class);
        $this->mocked_renderer = $this->createMock(RendererInterface::class);
        $this->rendering_service = new RenderingService(
            $this->mocked_source_loader,
            $this->mocked_renderer
        );
    }

    public function testRender(): void
    {
        $this->mocked_source_loader
            ->expects($this->once())
            ->method('load')
            ->willReturnCallback(
                fn (string $name) => new Source($name, self::EXAMPLE_CODE)
            );
        $this->mocked_renderer
            ->expects($this->once())
            ->method('render')
            ->willReturnArgument(0);

        self::assertEquals(
            self::EXAMPLE_CODE,
            $this->rendering_service->render(self::EXAMPLE_NAME, [])
        );
    }
}
