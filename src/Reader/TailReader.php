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

    public function configure($file)
    {
        if (!file_exists($file)) {
            throw new \RuntimeException("log file is not exists. file:" . $file);
        }
        $this->file = $file;
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
            2 => array("file", "/dev/null", "a") // stderr is a file to write to
        );

        $cwd = '/tmp';
        $this->process = proc_open($command, $descriptors, $this->pipes, $cwd);
        $this->handle = $this->pipes[1];
    }

    public function info()
    {
        return $this->file;
    }

    /**
     * read from stream
     * @param null $length
     * @return bool|string If there is no more data to read, the process will be blocked
     */
    public function read($length = null)
    {
        return fgets($this->handle);
    }

    /**
     * close stream
     * @return mixed
     */
    public function close()
    {
        if(!is_resource($this->process)) {
            return;
        }
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