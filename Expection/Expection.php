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
 *
 */

namespace Softhub99\Zest_Framework\Expection;

use Softhub99\Zest_Framework\View\View;

class Expection
{
    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int    $level   Error level
     * @param string $message Error message
     * @param string $file    Filename the error was raised in
     * @param int    $line    Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (@error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);
        if (\Config\Config::SHOW_ERRORS) {
            echo '<h1>Fatal error</h1>';
            echo "<p>Uncaught exception: '".get_class($exception)."'</p>";
            echo "<p>Message: '".$exception->getMessage()."'</p>";
            echo '<p>Stack trace:<pre>'.$exception->getTraceAsString().'</pre></p>';
            echo "<p>Thrown in '".$exception->getFile()."' on line ".$exception->getLine().'</p>';
        } else {
            $log = '../Storage /Logs/'.date('Y-m-d').'.log';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '".get_class($exception)."'";
            $message .= " with message '".$exception->getMessage()."'";
            $message .= "\nStack trace: ".$exception->getTraceAsString();
            $message .= "\nThrown in '".$exception->getFile()."' on line ".$exception->getLine();
            error_log($message);
            echo View::View("errors/$code");
        }
    }
}
