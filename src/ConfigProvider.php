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
            'dependencies' => [
                SettingsRepository::class => SettingsManager::class,
            ],
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
                    'source' => __DIR__ . '/../publish/2014_03_01_121230_create_settings_table.php',
                    'destination' => BASE_PATH . '/migrations/2014_03_01_121230_create_settings_table.php',
                ],
            ],
        ];
    }
}