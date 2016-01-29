<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:32
 */

namespace Jenner\LogMonitor;


use Jenner\SimpleFork\Pool;
use Monolog\Handler\NullHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Monitor
{
    /**
     * @var LoggerInterface
     */
    protected $logger;


    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        if (is_null($logger)) {
            $this->logger = new Logger("monitor");
            $this->logger->pushHandler(new NullHandler());
        } else {
            $this->logger = $logger;
        }
        $this->pool = new Pool();
    }

    public function addTask(MonitorTask $task)
    {
        $this->pool->execute($task);
    }

    /**
     * start monitor
     */
    public function start()
    {
        pcntl_signal(SIGTERM, array($this, 'signal'));
        $this->pool->wait();
    }

    public function signal($signal)
    {
        switch ($signal) {
            case SIGTERM:
                $this->pool->shutdown(SIGTERM);
                break;
        }
    }
}