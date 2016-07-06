<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 9:52
 */

namespace Jenner\LogMonitor\Reader;


class TailReader implements ReaderInterface
{
    protected $file;
    protected $error_file;
    protected $handle;
    protected $pipes;
    protected $process;

    // log file which need to be monitored
    const LOG_FILE = "log_file";
    // error log for `tail` command
    const ERR_FILE = "err_file";

    public function configure(array $config)
    {
        if (empty($config[self::LOG_FILE])) {
            throw new \InvalidArgumentException("empty param " . self::LOG_FILE);
        }
        if (!file_exists($config[self::LOG_FILE])) {
            throw new \RuntimeException("log file is not exists");
        }
        $this->file = $config[self::LOG_FILE];
        if (empty($config[self::ERR_FILE])) {
            $this->error_file = "/dev/null";
        } else {
            if (!file_exists($config[self::ERR_FILE])) {
                $touch = touch($config[self::ERR_FILE]);
                if ($touch === false) {
                    throw new \RuntimeException("create error file failed");
                }
            }
            $this->error_file = $config[self::ERR_FILE];
        }
    }

    /**
     * open stream
     */
    public function open()
    {
        $command = "tail -F {$this->file}";
        $descriptors = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("file", $this->error_file, "a") // stderr is a file to write to
        );

        $cwd = '/tmp';
        $this->process = proc_open($command, $descriptors, $this->pipes, $cwd);
        $this->handle = $this->pipes[1];
    }

    /**
     * read from stream
     * @param null $length
     * @return bool|string If there is no more data to read, the process will be blocked
     */
    public function read($length = null)
    {
        if (!is_null($length)) {
            $content = fgets($this->handle, $length);
        } else {
            $content = fgets($this->handle);
        }

        return $content;
    }

    /**
     * close stream
     * @return mixed
     */
    public function close()
    {
        $status = proc_get_status($this->process);
        if ($status['running'] == true) { //process ran too long, kill it
            //close all pipes that are still open
            @fclose($this->pipes[0]); //stdin
            @fclose($this->pipes[1]); //stdout
            @fclose($this->pipes[2]); //stderr
            //get the parent pid of the process we want to kill
            $parent_pid = $status['pid'];
            //use ps to get all the children of this process, and kill them
            $pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $parent_pid`);
            foreach ($pids as $pid) {
                if (is_numeric($pid)) {
                    posix_kill($pid, 9); //9 is the SIGKILL signal
                }
            }

            proc_close($this->process);
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}