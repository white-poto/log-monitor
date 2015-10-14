<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:39
 */

namespace Jenner\LogMonitor;


use Jenner\LogMonitor\Filter\ExceptionFilter;

class FilterFactory
{
    /**
     * @param null $classname
     * @return ExceptionFilter
     */
    public static function create($classname = null)
    {
        if (is_object($classname)) {
            return $classname;
        }

        if (is_null($classname)) {
            return new ExceptionFilter();
        }

        if (!class_exists($classname)) {
            throw new \RuntimeException($classname . ' class is not exists');
        }

        $reflect = new \ReflectionClass($classname);
        $parent_class = "\\AdTeam\\LogMonitor\\Filter\\FilterInterface";
        if (!$reflect->isSubclassOf($parent_class)) {
            throw new \RuntimeException($classname . ' must be a sub class of ' . $parent_class);
        }

        return new $classname();
    }
}