<?php

namespace Larva\Settings;

use Hyperf\DbConnection\Model\Model;

class SettingEloquent extends Model
{
    public const CREATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected ?string $table = 'settings';

    /**
     * 允许批量赋值的属性
     * @var array
     */
    public array $fillable = [
        'key', 'value', 'cast_type'
    ];

    /**
     * 应该被调整为日期的属性
     *
     * @var array
     */
    protected array $dates = [
        'updated_at',
    ];
}