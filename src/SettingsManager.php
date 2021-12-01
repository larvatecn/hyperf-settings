<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan JiYuan Information Technology Co., Ltd.
 * @link https://www.yaoqiyuan.com/
 */

namespace Larva\Settings;

use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Collection;

class SettingsManager implements SettingsRepository
{
    /**
     * 缓存 Key
     * @var string
     */
    protected string $cacheKey = 'system:settings';

    /**
     * 变量类型
     * @var string
     */
    protected string $castTypes = 'system:settings:cast_types';

    /**
     * 将数据库配置刷到 Redis
     */
    public function refresh()
    {
        $settings = [];
        $castTypes = [];
        SettingEloquent::all()->each(function ($setting) use (&$settings, &$castTypes) {
            $castTypes[$setting['key']] = $setting['cast_type'];
            $settings[$setting['key']] = $setting['value'];
        });
        $this->redis()->hMSet($this->cacheKey, $settings);
        $this->redis()->hMSet($this->castTypes, $castTypes);
    }

    /**
     * 获取所有的设置
     * @param boolean $reload 是否重载
     * @return Collection
     */
    public function all(bool $reload = false): Collection
    {
        if ($reload) {
            $this->refresh();
        }
        $data = $this->redis()->hGetAll($this->cacheKey);
        $castTypes = $this->redis()->hGetAll($this->castTypes);
        $settings = [];
        foreach ($data as $key => $setting) {
            $castType = $castTypes[$key] ?? 'string';
            switch ($castType) {
                case 'int':
                case 'integer':
                    $value = (int)$setting;
                    break;
                case 'float':
                    $value = (float)$setting;
                    break;
                case 'boolean':
                case 'bool':
                    $value = (bool)$setting;
                    break;
                default:
                    $value = $setting;
            }
            Arr::set($settings, $key, $value);
        }
        return collect($settings);
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
        $this->refresh();//刷到Redis
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
        $this->refresh();//刷到Redis
        return true;
    }

    /**
     * 获取Redis连接实例.
     * @return mixed|Redis
     */
    public function redis()
    {
        return ApplicationContext::getContainer()->get(Redis::class);
    }
}