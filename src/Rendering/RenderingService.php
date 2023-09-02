<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Rendering;

use Shockyrow\Sandbox\Rendering\Entities\Source;
use Shockyrow\Sandbox\Rendering\Entities\Template;
use Shockyrow\Sandbox\Rendering\Loaders\ArraySourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\ChainSourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\DottedFilesystemSourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\FilesystemSourceLoader;
use Shockyrow\Sandbox\Rendering\Loaders\SourceLoaderInterface;
use Shockyrow\Sandbox\Rendering\Renderers\ChainRenderer;
use Shockyrow\Sandbox\Rendering\Renderers\RendererInterface;
use Shockyrow\Sandbox\Rendering\Renderers\VariableRenderer;

final class RenderingService
{
    private SourceLoaderInterface $loader;
    private RendererInterface $renderer;

    public function __construct(
        SourceLoaderInterface $loader,
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
        $filesystem_loader = new FilesystemSourceLoader($path);

        return new self(
            new ChainSourceLoader([
                $filesystem_loader,
                new DottedFilesystemSourceLoader($filesystem_loader),
                new ArraySourceLoader($templates),
            ]),
            new ChainRenderer([
                new VariableRenderer(new DataManager()),
            ])
        );
    }

    public function render(string $name, array $data): string
    {
        $code = $this->loader->load($name);
        $template = $this->renderer->render(
            new Template(new Source($name, $code), $data)
        );

        return $template->getSource()->getCode();
    }
}
