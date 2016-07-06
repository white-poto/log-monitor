<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/6/23
 * Time: 11:39
 */

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$reader = new \Jenner\LogMonitor\Reader\TailReader();
$reader->configure('/tmp/log-monitor.log');

$reader->open();
while(true) {
    var_dump($reader->read());
}
