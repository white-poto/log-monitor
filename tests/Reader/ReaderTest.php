<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/6/23
 * Time: 11:06
 */

namespace Jenner\LogMonitor\Test\Reader;


use Jenner\LogMonitor\Reader\Reader;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $file = "/tmp/log-monitor.log";
        $this->setExpectedException("\\Exception", "log file is not exists. file:" . $file);
        if(file_exists($file)) unlink($file);
        new Reader($file);
    }

    public function testRead() {
        $file = "/tmp/log-monitor.log";
        touch($file);
        $reader = new Reader($file);
        $reader->open();
        file_put_contents($file, "test", FILE_APPEND);
        $line = $reader->read();
        var_dump($line);

        $this->assertEquals($line, "test");
    }
}