<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Core\Services;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Core\Services\RenderingService;

final class RenderingServiceTest extends TestCase
{
    private string $filepath;
    private string $filename;
    private RenderingService $rendering_service;

    public function setUp(): void
    {
        $views_dir = __DIR__;
        $this->filepath = tempnam($views_dir, 'view');
        $this->filename = substr($this->filepath, strlen($views_dir));

        $this->rendering_service = new RenderingService($views_dir);
    }

    protected function tearDown(): void
    {
        unlink($this->filepath);
    }

    public static function provideTestRender(): array
    {
        return [
            'variable' => [
                <<<'HTML'
<button><?= $title ?></button>
HTML,
                [
                    'title' => 'example',
                ],
                <<<HTML
<button>example</button>
HTML
            ],
            'loop' => [
                <<<'HTML'
<ul>
<?php foreach ($list as $index => $item): ?>
    <li id="<?= $index ?>"><?= $item ?></li>
<?php endforeach; ?>
</ul>
HTML,
                [
                    'list' => ['one', 'two', 'three'],
                ],
                <<<HTML
<ul>
    <li id="0">one</li>
    <li id="1">two</li>
    <li id="2">three</li>
</ul>
HTML
            ],
            'condition #1' => [
                <<<'HTML'
<?php if ($value === true): ?>
<p>It was true</p>
<?php else: ?>
<p>It was false</p>
<?php endif; ?>
HTML,
                [
                    'value' => true,
                ],
                <<<HTML
<p>It was true</p>

HTML
            ],
            'condition #2' => [
                <<<'HTML'
<?php if ($value === true): ?>
<p>It was true</p>
<?php else: ?>
<p>It was false</p>
<?php endif; ?>
HTML,
                [
                    'value' => false,
                ],
                <<<HTML
<p>It was false</p>

HTML
            ],
        ];
    }

    /**
     * @dataProvider provideTestRender
     */
    public function testRender(string $contents, array $data, string $expected_result): void
    {
        file_put_contents($this->filepath, $contents);

        self::assertEquals(
            $expected_result,
            $this->rendering_service->render($this->filename, $data)
        );
    }
}
