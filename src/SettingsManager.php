<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan JiYuan Information Technology Co., Ltd.
 * @link https://www.yaoqiyuan.com/
 */

namespace Larva\Settings;

use Hyperf\Utils\Arr;
use Hyperf\Utils\Collection;

class SettingsManager implements SettingsRepository
{
    /**
     * @var Collection
     */
    protected Collection $settings;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settings = new Collection();
    }

    /**
     * 获取所有的设置
     * @param bool $reload
     * @return Collection
     */
    public function all(bool $reload = false): Collection
    {
        if ($this->settings->isEmpty() || $reload) {
            $settings = [];
            SettingEloquent::all()->each(function ($setting) use (&$settings) {
                switch ($setting['cast_type']) {
                    case 'int':
                    case 'integer':
                        $value = (int)$setting['value'];
                        break;
                    case 'float':
                        $value = (float)$setting['value'];
                        break;
                    case 'boolean':
                    case 'bool':
                        $value = (bool)$setting['value'];
                        break;
                    default:
                        $value = $setting['value'];
                }
                Arr::set($settings, $setting['key'], $value);
            });
            $this->settings = collect($settings);
        }
        return $this->settings;
    }

    /**
     * 指定的设置是否存在
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return Arr::has($this->all(), $key);
    }

    /**
     * 获取设置
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return Arr::get($this->all(), $key, $default);
    }

    /**
     * 获取设置组
     * @param string $section
     * @return array
     */
    public function section(string $section): array
    {
        return Arr::get($this->all(), $section);
    }

    /**
     * 保存设置
     * @param string $key
     * @param mixed|null $value
     * @param string $cast_type
     * @return bool
     */
    public function set(string $key, $value = null, string $cast_type = 'string'): bool
    {
        if (is_array($value)) {
            return false;
        }
        //写库
        $query = SettingEloquent::query()->where('key', '=', $key);
        $method = $query->exists() ? 'update' : 'insert';
        $query->$method(compact('key', 'value', 'cast_type'));
        $this->all(true);//重载
        return true;
    }

    /**
     * 删除设置
     * @param string $key
     * @return true
     */
    public function forge(string $key): bool
    {
        SettingEloquent::query()->where('key', '=', $key)->delete();
        $this->all(true);//重载
        return true;
    }
}