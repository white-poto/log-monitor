<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:52
 */

namespace Jenner\LogMonitor\Reader;


class Reader extends AbstractReader
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var resource
     */
    protected $handle;

    /**
     * open stream
     */
    public function open()
    {
        $command = "tail -f {$this->file} 2>&1";
        $this->handle = popen($command, 'r');
    }

    /**
     * read from stream
     * @param null $length
     * @return bool|string
     */
    public function read($length = null)
    {
        if (!$this->hasMore()) return false;

        if (!is_null($length)) {
            return fgets($this->handle, $length);
        }
        return fgets($this->handle);
    }

    /**
     * if has more data or not
     * @return bool
     */
    public function hasMore()
    {
        return !feof($this->handle);
    }

    /**
     * close stream
     * @return mixed
     */
    public function close()
    {
        return fclose($this->handle);
    }
}