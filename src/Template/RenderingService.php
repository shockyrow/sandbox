<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Template;

use Shockyrow\Sandbox\Template\Loaders\ArrayLoader;
use Shockyrow\Sandbox\Template\Loaders\ChainLoader;
use Shockyrow\Sandbox\Template\Loaders\DottedFilesystemLoader;
use Shockyrow\Sandbox\Template\Loaders\FilesystemLoader;
use Shockyrow\Sandbox\Template\Loaders\LoaderInterface;
use Shockyrow\Sandbox\Template\Renderers\ChainRenderer;
use Shockyrow\Sandbox\Template\Renderers\RendererInterface;
use Shockyrow\Sandbox\Template\Renderers\VariableRenderer;

final class RenderingService
{
    private LoaderInterface $loader;
    private RendererInterface $renderer;

    public function __construct(
        LoaderInterface $loader,
        RendererInterface $renderer
    ) {
        $this->loader = $loader;
        $this->renderer = $renderer;
    }

    /**
     * @param string[] $templates
     */
    public static function create(string $path = '', array $templates = []): self
    {
        $filesystem_loader = new FilesystemLoader($path);

        return new self(
            new ChainLoader([
                $filesystem_loader,
                new DottedFilesystemLoader($filesystem_loader),
                new ArrayLoader($templates),
            ]),
            new ChainRenderer([
                new VariableRenderer(new DataManager()),
            ])
        );
    }

    public function render(string $name, array $data): string
    {
        $code = $this->loader->load($name);

        return $this->renderer->render(
            new Template(new Source($name, $code), $data)
        );
    }
}
