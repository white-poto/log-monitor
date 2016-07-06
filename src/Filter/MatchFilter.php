<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/14
 * Time: 10:10
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\ReaderInterface;

class MatchFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $matches;

    /**
     * @var bool
     */
    protected $ignore_case;

    /**
     * @param array|string $matches
     * @param bool $ignore_case
     */
    public function __construct($matches, $ignore_case = true)
    {
        if (is_array($matches)) {
            $this->matches = $matches;
        } else {
            $this->matches = array($matches);
        }
        $this->ignore_case = $ignore_case;
    }

    /**
     * @param $data
     * @return bool
     */
    public function filter($data)
    {
        foreach ($this->matches as $match) {
            if ($this->ignore_case) {
                if (stristr($data, $match)) {
                    return true;
                }
            } else {
                if (strstr($data, $match)) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * get more ten lines
     * @param $data
     * @param ReaderInterface $reader
     * @return string
     */
    public function getErrorMessage($data, ReaderInterface $reader)
    {
        $message = $data;
        $max_line = 10;
        for ($i = 0; $i < $max_line; $i++) {
            $message .= $reader->read();
        }

        return $message;
    }
}