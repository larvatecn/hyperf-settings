<?php

declare(strict_types=1);

/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan JiYuan Information Technology Co., Ltd.
 * @link https://www.yaoqiyuan.com/
 */

namespace Larva\Settings;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'migration',
                    'description' => 'The migration file for settings.',
                    'source' => __DIR__ . '/../publish/2021_07_02_143511_create_settings_table.php',
                    'destination' => BASE_PATH . '/migrations/2021_07_02_143511_create_settings_table.php',
                ],
            ],
        ];
    }
}