<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:58
 */

namespace Jenner\LogMonitor\Reader;


interface ReaderInterface
{
    /**
     * @param mixed $file
     * @return mixed
     */
    public function configure($file);

    /**
     * open stream
     * @return mixed
     */
    public function open();

    /**
     * read from stream
     * @return mixed
     */
    public function read();

    /**
     * close stream
     * @return mixed
     */
    public function close();
}