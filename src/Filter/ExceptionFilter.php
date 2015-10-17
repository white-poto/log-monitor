<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:10
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\AbstractReader;

class ExceptionFilter implements FilterInterface
{
    /**
     * @param $data
     * @return bool
     */
    public function filter($data)
    {
        if (stristr($data, 'exception')) {
            return false;
        }
        return true;
    }


    /**
     * get more ten lines
     * @param $data
     * @param AbstractReader $reader
     * @return string
     */
    public function getErrorMessage($data, AbstractReader $reader)
    {
        $message = $data;
        $max_line = 10;
        for ($i = 0; $i < $max_line; $i++) {
            $message .= $reader->read();
        }

        return $message;
    }
}