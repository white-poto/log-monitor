<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/14
 * Time: 14:52
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\AbstractReader;

class TestFilter implements FilterInterface
{

    public function filter($data)
    {
        return true;
    }

    public function getErrorMessage($data, AbstractReader $reader)
    {
        return $data;
    }
}