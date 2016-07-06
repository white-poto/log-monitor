<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:41
 */

namespace Jenner\LogMonitor\Notification;


interface NotificationInterface
{
    /**
     * send message to members
     * @param array $config
     * @param $message
     * @return mixed
     */
    public function send($config, $message);
}