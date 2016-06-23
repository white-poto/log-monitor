<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:34
 */

namespace Jenner\LogMonitor;


use Jenner\LogMonitor\Filter\FilterInterface;
use Jenner\LogMonitor\Notification\NotificationInterface;
use Jenner\LogMonitor\Reader\AbstractReader;
use Jenner\SimpleFork\Process;

class MonitorTask extends Process
{
    /**
     * @var AbstractReader
     */
    protected $reader;

    /**
     * @var FilterInterface
     */
    protected $filter;

    /**
     * @var NotificationInterface
     */
    protected $notify;

    /**
     * @param AbstractReader $reader
     * @param FilterInterface $filter
     * @param NotificationInterface $notify
     */
    public function __construct(
        AbstractReader $reader,
        FilterInterface $filter,
        NotificationInterface $notify
    )
    {
        parent::__construct();
        $this->reader = $reader;
        $this->filter = $filter;
        $this->notify = $notify;

        $this->registerSignalHandler(SIGTERM, array($this, 'signalHandler'));
    }

    /**
     * sub process run
     */
    public function run()
    {
        $this->reader->open();
        while (true) {
            $line = $this->reader->read();
            if($line === false) {
                usleep(200);
                continue;
            }
            if ($this->filter->filter($line)) {
                $message = $this->filter->getErrorMessage($line, $this->reader);
                $this->notify->send($this->reader->getFile(), $message);
            }
        }
    }

    protected function signalHandler($signal)
    {
        switch ($signal) {
            case SIGTERM :
                $this->reader->close();
                unset($this->reader);
                unset($this->filter);
                unset($this->notify);
                exit(0);
        }
    }
}