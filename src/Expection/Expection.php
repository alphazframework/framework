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
 * @since 1.0.0
 *
 * @license MIT
 */

namespace Zest\Expection;

use Zest\View\View;
use Zest\Common\Logger\Logger;

class Expection
{
    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param (int)    $level   Error level
     *        (string) $message Error message
     *        (string) $file    Filename the error was raised in
     *        (int)    $line    Line number in the file
     *
     * @since 1.0.0
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
     * @param (Exception) $exception The exception
     *
     * @since 1.0.0
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
        if (\Config\Config::SHOW_ERRORS) {
            echo '<h1>Fatal error</h1>';
            echo "<p>Uncaught exception: '".get_class($exception)."'</p>";
            echo "<p>Message: '".$exception->getMessage()."'</p>";
            echo '<p>Stack trace:<pre>'.$exception->getTraceAsString().'</pre></p>';
            echo "<p>Thrown in '".$exception->getFile()."' on line ".$exception->getLine().'</p>';
        } else {
            $logger = new Logger();
            $log = date('Y-m-d').'.log';
            $message = "Uncaught exception: '".get_class($exception)."'";
            $message .= " with message '".$exception->getMessage()."'";
            $message .= "\nStack trace: ".$exception->getTraceAsString();
            $message .= "\nThrown in '".$exception->getFile()."' on line ".$exception->getLine();
            $logger->setCustumFile($log)->error($message);
            echo View::View("errors/$code");
        }
    }
}
