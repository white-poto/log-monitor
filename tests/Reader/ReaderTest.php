<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/6/23
 * Time: 11:06
 */

namespace Jenner\LogMonitor\Test\Reader;

use Jenner\LogMonitor\Reader\TailReader;

class ReaderTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $file = "/tmp/log-monitor.log";
        $this->setExpectedException("\\RuntimeException", "log file is not exists. file:" . $file);
        if(file_exists($file)) unlink($file);
        $config = array('log_file' => $file);
        $reader = new TailReader();
        $reader->configure($config);
    }

    public function testRead() {
        $file = "/tmp/log-monitor.log";
        touch($file);
        $reader = new TailReader();
        $reader->configure($file);
        $reader->open();
        file_put_contents($file, "test\n", FILE_APPEND);
        $line = $reader->read();
        $this->assertEquals($line, "test\n");
    }
}