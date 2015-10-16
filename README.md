log-monitor
===============
A active log monitor based on tail command.

Why use log-monitor?
-----------------
Some times we want to known what happen when crontab task is running or 
what errors the had been written into error log by php script, and we want
to know quickly.
log-monitor can help you to monitor the log and notify the users who want to know.

What can log-monitor do?
--------------------
+ monitor the log by tail command
+ notify users when there is an error
+ custom log filter which will check the log is error or not
+ custom notificatition which will notify the users
+ custom reader if you do not want to use tail command

How to use log-monitro?
-----------------------
talk is cheap, show you the code:
```php
$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\ExceptionFilter();
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$process = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$process->run();
$process->wait();
```

How it works?
----------------------
When you create a MonitorProcess object and call the run method, 
it will start a sub process to call the tail command. Then it will 
read from the pipe and check the log is error or not. If there is an
error, it will call the notification to notify users who want to know.

If you have many logs to monitor, you can use the Monitor to manage them.
show you the code:
```php
$reader = new \Jenner\LogMonitor\Reader\Reader('/var/log/messages');
$filter = new Jenner\LogMonitor\Filter\ExceptionFilter();
$notify = new \Jenner\LogMonitor\Notification\EchoNotification();

$task = new \Jenner\LogMonitor\MonitorTask($reader, $filter, $notify);
$monitor = new \Jenner\LogMonitor\Monitor();
$monitor->addTask($task);
$monitor->start();
$monitor->wait();
```

Just remember that when you call the start method, do not forget to call wait method.