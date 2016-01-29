log-monitor
===============
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

How it works?
----------------------
When you create a MonitorTask object and call the `run` method, 
it will start a sub process to call the `tail` command. Then it will 
read from the pipe and check the log that if it is error or not. If there is an
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