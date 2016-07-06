<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:42
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\ReaderInterface;

interface FilterInterface
{
    public function filter($data);

    public function getErrorMessage($data, ReaderInterface $reader);
}