<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/1/29
 * Time: 14:30
 */

namespace Jenner\LogMonitor;


interface ConfigurableInterface
{
    /**
     * @param array $config
     * @return void
     */
    public function configure(array $config);
}