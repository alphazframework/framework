<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Common\Logger;

use Zest\Common\FileHandling;

class Logger extends AbstractLogger
{
    /**
     * Array of conversion levels.
     */
    protected $levels = [
        'emergency' => 0,
        'alert'     => 1,
        'critical'  => 2,
        'error'     => 3,
        'warning'   => 4,
        'notice'    => 5,
        'info'      => 6,
        'debug'     => 7,
    ];
    /**
     * Array of conversion levels in reverse order.
     */
    protected $s_levels = [
        0 => 'emergency',
        1 => 'alert',
        2 => 'critical',
        3 => 'error',
        4 => 'warning',
        5 => 'notice',
        6 => 'info',
        7 => 'debug',
    ];
    /**
     * Store the logs.
     */
    private $log;

    /**
     * Log.
     *
     * @param  $level Error level (string or PHP syslog priority)
     *         $message Error message
     *         $context Contextual array
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        if (is_string($level)) {
            if (!array_key_exists($level, $this->levels)) {
                throw new \Exception("Log level {$level} is not valid. Please use syslog levels instead", 500);
            } else {
                $level = $this->levels[$level];
            }
        }
        if (array_key_exists('exception', $context)) {
            if ($context['exception'] instanceof \Exception) {
                $exc = $context['exception'];
                $message .= " Exception: {$exc->getMessage()}";
                unset($context['exception']);
            } else {
                unset($context['exception']);
            }
        }
        $level = $this->s_levels[$level];

        return  $this->interpolate($message, $context, $level);
    }

    /**
     * Write the log message in files.
     *
     * @param  $string Error level (string or PHP syslog priority)
     *         $message Error message
     *
     * @return void
     */
    public function writer($level, $message)
    {
        $fileName = '.logs';
        $fileHandling = new FileHandling();
        $text = 'Date/time: '.date('Y-m-d h:i:s A')." , Level: $level , message: ".$message."\n" ;
        $file =  route()->storage_logs.'.logs';
        $fileHandling->open($file,'readWriteAppend')->write($text);
    }

    /**
     * Store the log.
     *
     * @param $log array
     *
     * @return array
     */
    public function store($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get the log message.
     *
     * @return array
     */
    public function get()
    {
        return $this->log;
    }

    /**
     * Log an Exception.
     *
     * @param  $level Error level (string or PHP syslog priority)
     *         $message Error message
     *         $context Contextual array
     *         $exception Exception
     *
     * @return void
     */
    public function logException($level, $message, array $context = [], $exception = null)
    {
        $this->log($level, $message, array_merge($context, ['exception'=>$exception]));
    }

    /**
     * Interpolate string with parameters.
     *
     * @param  $string String with parameters
     *         $params Parameter arrays
     *         $level Level of log
     *
     * @return void
     */
    public function interpolate($string, array $params, $level)
    {
        foreach ($params as $placeholder => $value) {
            $params['{'.(string) $placeholder.'}'] = (string) $value;
            unset($params[$placeholder]);
        }
        $message = strtr($string, $params);
        $this->writer($level, $message);
        $this->store([
            'message' => $message,
            'level'   => $level,
        ]);
    }
}
