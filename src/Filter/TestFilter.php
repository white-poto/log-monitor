<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 14:52
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\ReaderInterface;

class TestFilter implements FilterInterface
{

    public function filter($data)
    {
        return true;
    }

    public function getErrorMessage($data, ReaderInterface $reader)
    {
        return $data;
    }
}