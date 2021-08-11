<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan JiYuan Information Technology Co., Ltd.
 * @link https://www.yaoqiyuan.com/
 */

use Hyperf\Utils\ApplicationContext;
use Larva\Settings\SettingsRepository;

if (!function_exists('settings')) {
    /**
     * Get setting value or object.
     *
     * @param string $key
     * @param mixed|null $default
     * @return SettingsRepository|mixed
     */
    function settings(string $key = '', $default = null)
    {
        if (!ApplicationContext::hasContainer()) {
            throw new \RuntimeException('The application context lacks the container.');
        }

        $store = ApplicationContext::getContainer()->get(SettingsRepository::class);

        if (empty($key)) {
            return $store;
        }
        return $store->get($key, $default);
    }
}