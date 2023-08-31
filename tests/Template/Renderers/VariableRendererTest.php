<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template\Renderers;

use PHPUnit\Framework\MockObject\Rule\InvokedAtLeastCount;
use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\DataManager;
use Shockyrow\Sandbox\Template\Renderers\VariableRenderer;
use Shockyrow\Sandbox\Template\Source;
use Shockyrow\Sandbox\Template\Template;

class VariableRendererTest extends TestCase
{
    private const EXAMPLE_DATA_VALUE = 'example';

    public static function provideTestRender(): array
    {
        return [
            [
                '<button>{{title}}</button>',
                [
                    'title' => 'example',
                ],
                "<button>example</button>",
            ],
            [
                '<button>{{ title}}</button>',
                [
                    'title' => 'example',
                ],
                "<button>example</button>",
            ],
            [
                '<button>{{title }}</button>',
                [
                    'title' => 'example',
                ],
                "<button>example</button>",
            ],
            [
                '<button>{{ title }}</button>',
                [
                    'title' => 'example',
                ],
                "<button>example</button>",
            ],
            [
                '<button>{{title}}</button>',
                [],
                "<button>title</button>",
            ],
        ];
    }

    /**
     * @dataProvider provideTestRender
     */
    public function testRender(string $template, array $data, string $expected_result): void
    {
        $mocked_data_manager = $this->createMock(DataManager::class);
        $mocked_data_manager
            ->expects($this->once())
            ->method('setData')
            ->with($data);
        $mocked_data_manager
            ->expects(new InvokedAtLeastCount(count($data)))
            ->method('get')
            ->willReturnCallback(
                fn ($key) => $data[$key] ?? $key
            );
        $variable_renderer = new VariableRenderer($mocked_data_manager);
        $rendered_template = $variable_renderer->render(
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
