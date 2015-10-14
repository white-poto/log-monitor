<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:10
 */

namespace Jenner\LogMonitor\Notification;


class EchoNotification implements NotificationInterface
{

    /**
     * send message to members
     * @param $message
     * @return mixed
     */
    public function send($file, $message)
    {
        echo 'file:' . $file . '. message:' . $message . PHP_EOL;
    }
}