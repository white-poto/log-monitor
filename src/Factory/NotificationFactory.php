<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:39
 */

namespace Jenner\LogMonitor\Factory;


use Jenner\LogMonitor\Notification\EchoNotification;

class NotificationFactory
{
    /**
     * @param $classname
     * @return EchoNotification
     */
    public static function create($classname)
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
        $parent_class = "\\AdTeam\\LogMonitor\\Notification\\NotificationInterface";
        if (!$reflect->isSubclassOf($parent_class)) {
            throw new \RuntimeException($classname . ' must be a sub class of ' . $parent_class);
        }

        return new $classname();
    }
}