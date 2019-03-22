<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 2.0.3
 *
 * @license MIT
 */

namespace Zest\Common\Logger;

use Zest\Files\FileHandling;

class Logger extends AbstractLogger
{
    /**
     * Array of conversion levels.
     *
     * @since 2.0.3
     *
     * @var array
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
     *
     * @since 2.0.3
     *
     * @var array
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
     *
     * @since 2.0.3
     *
     * @var array
     */
    private $log;

    /**
     * Store the logs.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $file;

    /**
     * Log.
     *
     * @param (string) $level Error level (string or PHP syslog priority)
     * @param (string) $message Error message
     * @param (array)  $context Contextual array
     *
     * @since 2.0.3
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
     * @param (string) $string Error level (string or PHP syslog priority)
     * @param (string) $message Error message
     *
     * @since 2.0.3
     *
     * @return void
     */
    public function writer($level, $message)
    {
        (!empty($this->file)) ? $fileName = $this->file : $fileName = '.logs';
        $fileHandling = new FileHandling();
        $text = 'Date/time: '.date('Y-m-d h:i:s A')." , Level: $level , message: ".$message."\n";
        $file = route()->storage->log.$fileName;
        $fileHandling->open($file, 'readWriteAppend')->write($text);
        $fileHandling->close();
    }

    /**
     * Set the custom file.
     *
     * @param (string) $name valid name of file if file not exists it create for you.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setCustomFile($name)
    {
        $this->file = $name;

        return $this;
    }

    /**
     * Store the log.
     *
     * @param (array) $log
     *
     * @since 2.0.3
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
     * @since 2.0.3
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
     * @param (string)    $level Error level (string or PHP syslog priority)
     * @oaram (string)    $message Error message
     * @param (array)     $context Contextual array
     * @param (Expection) $exception Exception
     *
     * @since 2.0.3
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
     * @param (string) $string String with parameters
     * @param (array)  $params Parameter arrays
     * @param (string) $level Level of log
     *
     * @since 2.0.3
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
