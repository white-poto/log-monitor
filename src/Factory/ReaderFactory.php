<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:39
 */

namespace Jenner\LogMonitor\Factory;


use Jenner\LogMonitor\Reader\Reader;

class ReaderFactory
{
    /**
     * @param $file
     * @param null $classname
     * @return Reader
     */
    public static function create($file, $classname = null)
    {
        if (is_object($classname)) {
            return $classname;
        }

        if (is_null($classname)) {
            return new Reader($file);
        }

        if (!class_exists($classname)) {
            throw new \RuntimeException($classname . ' class is not exists');
        }

        $reflect = new \ReflectionClass($classname);
        $parent_class = "\\AdTeam\\LogMonitor\\Reader\\AbstractReader";
        if (!$reflect->isSubclassOf($parent_class)) {
            throw new \RuntimeException($classname . ' must be a sub class of ' . $parent_class);
        }

        return new $classname($file);
    }
}