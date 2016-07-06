log-monitor
===========

[![Join the chat at https://gitter.im/huyanping/log-monitor](https://badges.gitter.im/huyanping/log-monitor.svg)](https://gitter.im/huyanping/log-monitor?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Latest Stable Version](https://poser.pugx.org/jenner/log-monitor/v/stable)](https://packagist.org/packages/jenner/log-monitor) 
[![Total Downloads](https://poser.pugx.org/jenner/log-monitor/downloads)](https://packagist.org/packages/jenner/log-monitor) 
[![Latest Unstable Version](https://poser.pugx.org/jenner/log-monitor/v/unstable)](https://packagist.org/packages/jenner/log-monitor) 
[![License](https://poser.pugx.org/jenner/log-monitor/license)](https://packagist.org/packages/jenner/log-monitor) 
[![travis](https://travis-ci.org/huyanping/log-monitor.svg)](https://travis-ci.org/huyanping/log-monitor)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/huyanping/log-monitor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/huyanping/log-monitor/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/huyanping/log-monitor/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/huyanping/log-monitor/?branch=master)

An active log monitor based on the `tail` command.

Why use log-monitor?
-----------------
Sometimes we want to know what is happening when crontab task is running or
what errors had been written into the php error log by php script, and we want
to know quickly.
log-monitor can help you to monitor the log and notify the users who want to know.

What can log-monitor do?
--------------------
+ monitor the log by the tail command
+ notify users when there is an error
+ custom log filter interface, which will check the log is error or not
+ custom notification interface, which will notify the users
+ custom reader interface, if you do not want to use the tail command

How to use log-monitor?
-----------------------
talk is cheap, show you the code:
```php
$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\MatchFilter("exception");
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$process = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$process->run();
$process->wait();
```
There are three interfaces:`AbstractReader`, `NotificationInterface`, `FilterInterface`.  
If you want to read log for somewhere else, you can create a class which extends `AbstractReader`.  
If you want to filter your log in different way, you can create a class which implements `FilterInterface`.  
If you want to send message to somewhere else, you can create a class which implements `NotificationInterface`.  

How it works?
----------------------
When you have created a MonitorTask object and call the `run` method, 
it will start a sub process and call the `tail` command in the sub process. Then it will 
read from the pipe and check the log by filter that if it is error or not. If there is an
error, it will call the notification to notify the users who want to know.
Just do not forget to call `wait` method to wait the sub process.

If you have many logs to monitor, you can use the Monitor to manage them.
show you the code:
```php
$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\MatchFilter("exception");
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$task = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$monitor = new \Jenner\LogMonitor\Monitor();
$monitor->addTask($task);
$monitor->start();
```

Just remember that when you call the `start` method, do not forget to call `wait` method.