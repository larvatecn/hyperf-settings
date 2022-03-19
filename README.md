# hyperf-settings

<p align="center">
    <a href="https://packagist.org/packages/larva/hyperf-settings"><img src="https://poser.pugx.org/larva/hyperf-settings/v/stable" alt="Stable Version"></a>
    <a href="https://packagist.org/packages/larva/hyperf-settings"><img src="https://poser.pugx.org/larva/hyperf-settings/downloads" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/larva/hyperf-settings"><img src="https://poser.pugx.org/larva/hyperf-settings/license" alt="License"></a>
</p>

适用于 Hyperf 的配置组件。

## 安装

```bash
composer require larva/hyperf-settings -vv
```

发布迁移文件

```bash
php ./bin/hyperf.php vendor:publish larva/hyperf-settings
```

## 使用

快捷使用
```bash
// 获取
$setting = settings('xx.aa', null);
```

```bash
//设置
settings()->set('xx.aa', 'value', 'string');
settings()->set('xx.bb', '1', 'bool');
```

或者直接使用实例
```bash
/** @var \Larva\Settings\SettingsRepository $settings
$settings = ApplicationContext::getContainer()->get(SettingsRepository::class);
// 获取
$setting = $settings->get('xx.aa', null);
$sets = $settings->section('xx');

var_dump($sets);
var_dump($setting);

//设置
$settings->set('xx.aa', 'value', 'string');
$settings->set('xx.bb', '1', 'bool');

if($settings->has('xx.bb')) {
  //配置存在
}

//重载配置
$settings->refresh();
//删除配置
$settings->forge('xx.bb');
```
