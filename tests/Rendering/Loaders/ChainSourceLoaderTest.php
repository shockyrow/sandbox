<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Rendering\Loaders;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Loaders\ChainSourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\SourceLoaderInterface;

class ChainSourceLoaderTest extends TestCase
{
    private const TOTAL_LOADERS = 10;
    private const EXAMPLE_TEMPLATE = '<button></button>';

    /**
     * @var MockObject[]|SourceLoaderInterface[]
     */
    private array $mocked_loaders;
    private ChainSourceLoader $loader;

    protected function setUp(): void
    {
        $this->mocked_loaders = [];

        foreach (range(1, self::TOTAL_LOADERS) as $ignored) {
            $this->mocked_loaders[] = $this->createMock(SourceLoaderInterface::class);
        }

        $this->loader = new ChainSourceLoader($this->mocked_loaders);
    }

    public function testLoad(): void
    {
        $last_loader = array_pop($this->mocked_loaders);

        foreach ($this->mocked_loaders as $mocked_loader) {
            $mocked_loader
                ->expects($this->once())
                ->method('exists')
                ->willReturn(false);
        }

        $last_loader
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $source = new Source('', self::EXAMPLE_TEMPLATE);

        $last_loader
            ->expects($this->once())
            ->method('load')
            ->willReturn($source);

        self::assertEquals(
            $source,
            $this->loader->load('')
        );
    }

    public function testExists(): void
    {
        $last_loader = array_pop($this->mocked_loaders);

        foreach ($this->mocked_loaders as $mocked_loader) {
            $mocked_loader
                ->expects($this->once())
                ->method('exists')
                ->willReturn(false);
        }

        $last_loader
            ->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        self::assertTrue($this->loader->exists(''));
    }
}
