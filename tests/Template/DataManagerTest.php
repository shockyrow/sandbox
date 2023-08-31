<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Tests\Template;

use PHPUnit\Framework\TestCase;
use Shockyrow\Sandbox\Template\DataManager;

final class DataManagerTest extends TestCase
{
    public static function provideTestGetReturnsDefault(): array
    {
        $random_default = time();

        return [
            'simple array data' => [
                ['example'],
                '0',
                null,
                'example',
            ],
            'complex array data' => [
                ['a' => ['example']],
                'a.0',
                null,
                'example',
            ],
            'empty key with random for default' => [
                'example',
                '',
                $random_default,
                $random_default,
            ],
            'invalid key with random for default' => [
                'example',
                '1',
                $random_default,
                $random_default,
            ],
            'empty key with null for default' => [
                'example',
                '',
                null,
                null,
            ],
            'invalid key with null for default' => [
                'example',
                '1',
                null,
                null,
            ],
        ];
    }

    /**
     * @dataProvider provideTestGetReturnsDefault
     */
    public function testGet($data, string $key, $default, $expected_result): void
    {
        $data_manager = new DataManager();
        $data_manager->setData($data);

        self::assertEquals($expected_result, $data_manager->get($key, $default));
    }
}
