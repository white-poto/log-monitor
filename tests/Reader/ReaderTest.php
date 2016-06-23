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
        echo 'open' . PHP_EOL;
        $reader->open();
        echo 'has more 1' . PHP_EOL;
        $this->assertTrue($reader->hasMore());
        echo 'put' . PHP_EOL;
        file_put_contents($file, "test", FILE_APPEND);
        echo 'has more 2' . PHP_EOL;
        $this->assertTrue($reader->hasMore());
        echo 'read' . PHP_EOL;
        $line = $reader->read();
        $this->assertEquals($line, "test");
        echo 'has more 3' . PHP_EOL;
        $this->assertFalse($reader->hasMore());
    }
}