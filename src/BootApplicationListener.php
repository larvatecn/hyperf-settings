<?php

declare(strict_types=1);
/**
 * This is NOT a freeware, use is subject to license terms.
 * @copyright Copyright (c) 2021-2099 Jinan Jiyuan Information Technology Co., Ltd.
 * @link http://www.jiyuanmed.cn/
 */

namespace Larva\Settings;

use Hyperf\Contract\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;

class BootApplicationListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            BootApplication::class,
        ];
    }

    /**
     * @param object $event
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function process(object $event)
    {
        $store = $this->container->get(SettingsRepository::class);
        $store->all(true);
    }
}