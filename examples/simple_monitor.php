<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/17
 * Time: 14:33
 */

$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\MatchFilter("exception");
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$task = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$monitor = new \Jenner\LogMonitor\Monitor();
$monitor->addTask($task);
$monitor->start();
