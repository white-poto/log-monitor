<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/17
 * Time: 14:32
 */

$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\MatchFilter("exception");
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$process = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$process->run();
$process->wait();