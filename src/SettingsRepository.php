<?php

namespace Larva\Settings;

use Hyperf\Collection\Collection;

interface SettingsRepository
{
    /**
     * 获取所有的设置
     * @param boolean $reload 是否重载
     * @return Collection
     */
    public function all(bool $reload = false): Collection;

    /**
     * 指定的设置是否存在
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * 获取设置
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * 获取设置组
     * @param string $section
     * @return array
     */
    public function section(string $section): array;

    /**
     * 保存设置
     * @param string $key
     * @param mixed|null $value
     * @param string $cast_type
     * @return bool
     */
    public function set(string $key, $value = null, string $cast_type = 'string'): bool;

    /**
     * 删除设置
     * @param string $key
     * @return mixed
     */
    public function forge(string $key): bool;
}