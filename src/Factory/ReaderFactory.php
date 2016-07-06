<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:39
 */

namespace Jenner\LogMonitor\Factory;


class ReaderFactory
{
    /**
     * @param array $config
     * @param $classname
     * @return mixed
     */
    public static function create($config, $classname)
    {
        if (is_object($classname)) {
            return $classname;
        }

        if (empty($classname)) {
            throw new \InvalidArgumentException("empty class name");
        }

        if (!class_exists($classname)) {
            throw new \RuntimeException($classname . ' class is not exists');
        }

        $reflect = new \ReflectionClass($classname);
        $parent_class = "\\AdTeam\\LogMonitor\\Reader\\ReaderInterface";
        if (!$reflect->isSubclassOf($parent_class)) {
            throw new \RuntimeException($classname . ' must be a sub class of ' . $parent_class);
        }

        $obj = new $classname();
        $obj->configure($config);

        return $obj;
    }
}