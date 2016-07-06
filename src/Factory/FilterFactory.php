<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:39
 */

namespace Jenner\LogMonitor\Factory;


use Jenner\LogMonitor\Filter\FilterInterface;

class FilterFactory
{
    /**
     * @param null $class_name
     * @return FilterInterface
     */
    public static function create($class_name)
    {
        if (is_object($class_name)) {
            return $class_name;
        }

        if (empty($class_name)) {
            throw new \InvalidArgumentException("empty class name");
        }

        if (!class_exists($class_name)) {
            throw new \RuntimeException($class_name . ' class is not exists');
        }

        $reflect = new \ReflectionClass($class_name);
        $parent_class = "\\AdTeam\\LogMonitor\\Filter\\FilterInterface";
        if (!$reflect->isSubclassOf($parent_class)) {
            throw new \RuntimeException($class_name . ' must be a sub class of ' . $parent_class);
        }

        return new $class_name();
    }
}