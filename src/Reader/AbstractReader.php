<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:58
 */

namespace Jenner\LogMonitor\Reader;


abstract class AbstractReader
{
    protected $file;

    public function __construct($file)
    {
        if(!file_exists($file)) {
            throw new \Exception("log file is not exists. file:" . $file);
        }
        $this->file = $file;
    }

    /**
     * get file
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * open stream
     * @return mixed
     */
    abstract public function open();

    /**
     * read from stream
     * @return mixed
     */
    abstract public function read();

    /**
     * if has more data or not
     * @return mixed
     */
    abstract public function hasMore();

    /**
     * close stream
     * @return mixed
     */
    abstract public function close();
}