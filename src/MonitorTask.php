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
     * @var int check reader after $usleep ms every time.
     */
    protected $usleep;

    /**
     * @param AbstractReader $reader
     * @param FilterInterface $filter
     * @param NotificationInterface $notify
     */
    public function __construct(
        AbstractReader $reader,
        FilterInterface $filter,
        NotificationInterface $notify,
        $usleep = 10
    )
    {
        parent::__construct();
        $this->reader = $reader;
        $this->filter = $filter;
        $this->notify = $notify;
        $this->usleep = $usleep;
    }

    /**
     *
     */
    public function run()
    {
        $this->reader->open();
        while (($line = $this->reader->read()) !== false) {
            if (!$this->filter->filter($line)) {
                $message = $this->filter->getErrorMessage($line, $this->reader);
                $this->notify->send($this->reader->getFile(), $message);
            }
            usleep($this->usleep);
        }
    }
}