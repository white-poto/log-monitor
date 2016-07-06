<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/6/23
 * Time: 11:39
 */

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$reader = new \Jenner\LogMonitor\Reader\TailReader();
$reader->configure(array(
    \Jenner\LogMonitor\Reader\TailReader::LOG_FILE => '/tmp/log-monitor.log',
    \Jenner\LogMonitor\Reader\TailReader::ERR_FILE => '/tmp/error.log',
));

$reader->open();
while($reader->hasMore()) {
    var_dump($reader->read());
}
