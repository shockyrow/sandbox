<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template\Loaders;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\Loaders\ChainLoader;
use Shockyrow\Sandbox\Template\Loaders\LoaderInterface;

class ChainLoaderTest extends TestCase
{
    private const TOTAL_LOADERS = 10;
    private const EXAMPLE_TEMPLATE = '<button></button>';

    /**
     * @var MockObject[]|LoaderInterface[]
     */
    private $mocked_loaders;
    private ChainLoader $loader;

    protected function setUp(): void
    {
        foreach (range(1, self::TOTAL_LOADERS) as $_) {
            $this->mocked_loaders[] = $this->createMock(LoaderInterface::class);
        }

        $this->loader = new ChainLoader($this->mocked_loaders);
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


        $last_loader
            ->expects($this->once())
            ->method('load')
            ->willReturn(self::EXAMPLE_TEMPLATE);

        self::assertEquals(self::EXAMPLE_TEMPLATE, $this->loader->load(''));
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
