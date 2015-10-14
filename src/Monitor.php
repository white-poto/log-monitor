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
     * @var array monitor config
     */
    protected $config;

    /**
     * @var LoggerInterface
     */
    protected $logger;


    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @param $config
     * @param LoggerInterface $logger
     */
    public function __construct($config, LoggerInterface $logger = null)
    {
        $this->config = $config;
        if (is_null($logger)) {
            $this->logger = new Logger("monitor");
            $this->logger->pushHandler(new NullHandler());
        } else {
            $this->logger = $logger;
        }
    }

    /**
     * start monitor
     */
    public function start()
    {
        $this->pool = new Pool();
        foreach ($this->config as $config) {
            if (!file_exists($config['file'])) {
                $this->logger->error($config['file'] . ' is not exists');
            }
            $filter = FilterFactory::create($config['filter']);
            $notify = NotificationFactory::create($config['notify']);
            $reader = ReaderFactory::create($config['file'], $config['reader']);
            $process = new MonitorProcess($reader, $filter, $notify);
            $this->pool->submit($process);
        }
        $this->pool->start();
        pcntl_signal(SIGTERM, array($this, 'signal'));
        $this->pool->wait();
    }

    public function signal($signal)
    {
        switch ($signal) {
            case SIGTERM:
                $this->pool->shutdown(SIGKILL);
                break;
        }
    }
}