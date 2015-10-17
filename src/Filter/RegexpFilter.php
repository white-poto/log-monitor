<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2015/10/17
 * Time: 14:38
 */

namespace Jenner\LogMonitor\Filter;


use Jenner\LogMonitor\Reader\AbstractReader;

class RegexpFilter implements FilterInterface
{
    /**
     * @var array
     */
    protected $regexps;

    /**
     * @param array $regexps
     */
    public function __construct($regexps)
    {
        if (is_array($regexps)) {
            $this->regexps = $regexps;
        } else {
            $this->regexps = array($regexps);
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function filter($data)
    {
        foreach ($this->regexps as $regexp) {
            if (preg_match($regexp, $data) != 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * get more ten lines
     * @param $data
     * @param AbstractReader $reader
     * @return string
     */
    public function getErrorMessage($data, AbstractReader $reader)
    {
        $message = $data;
        $max_line = 10;
        for ($i = 0; $i < $max_line; $i++) {
            $message .= $reader->read();
        }

        return $message;
    }
}