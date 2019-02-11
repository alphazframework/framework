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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\Expection\Whoops;
use Zest\Common\Logger\Logger;
use Zest\View\View;

class Whoops
{
    /**
     * Store the errors stack
     *
     * @since 3.0.0
     *
     * @var array
    */
    private $stack = [];

    /**
     * __construct
     *
     * @since 3.0.0
    */
    public function __construct()
    {
        error_reporting(E_ALL);
        set_exception_handler([$this, 'exception']);
        set_error_handler([$this, 'error']);
    }

    /**
     * expection handler
     *
     * @since 3.0.0
     *
     * @return mixed
    */
    public function exception($e)
    {
        $this->setParams(
            $e->getCode(),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine(),
            $e->getTraceAsString());

        return $this->render();
    }

    /**
     * Error handler
     *
     * @since 3.0.0
     *
     * @return mixed
    */       
    public function error($code, $msg, $file, $line)
    {
        $this->setParams($code, $msg, $file, $line, '');

        return $this->render();
    }

    /**
     * Set the error item to stack
     *
     * @param (int) $code
     * @param (string) $msg
     * @param (string) $file
     * @param (int) $line
     * @param (string) $trace
     *
     * @since 3.0.0
     *
     * @return mixed
    */   
    protected function setParams($code, $msg, $file, $line, $trace)
    {
        return $this->stack = [
            'message' => $msg,
            'file' => $file,
            'line' => $line,
            'code' => ($code === 0) ? 404 : $code ,
            'trace' => $trace,
            'previewCode' => '',
        ];
    } 

    /**
     * Get the code from file.
     *
     * @since 3.0.0
     *
     * @return void
    */   
    protected function getPreviewCode()
    {
        $file = file($this->stack['file']);
        $line = $this->stack['line'];
        $_line = $line - 1;
        if ($_line - 5 >= 0) {
            $start = $_line - 5;
            $end = $_line + 5;
        } else {
            $start = $_line;
            $end = $line;
        }
        for ($i = $start; $i <= $end; $i++) {
            if (!isset($file[$i])) {
                break;
            }
            $text = escape($file[$i]);
            if ($i === $_line) {
                $this->stack['previewCode'] .=
                    "<span style='background:red' class='line'>" . ($i + 1) . '</span>' .
                    "<span style='background:red'>" . $text . '</span><br>';
                continue;
            }
            $this->stack['previewCode'] .=
                "<span class='line'>" . ($i + 1) . '</span>' .
                "<span>" . $text . '</span><br>';
        }      
    }

    /**
     * Rander the error
     *
     * @since 3.0.0
     *
     * @return mixed
    */    
    public function render()
    {
        $this->getPreviewCode();
        $stack = $this->stack;
        if (__config()->config->show_errors === true) {
            $file = "views/view.php";
            require $file;
        } else {
            $logger = new Logger();
            $log = date('Y-m-d').'.log';
            $message = "Message: ".$stack['message'];
            $message .= "\n Stack trace: ".$stack['trace'];
            $message .= "\n Thrwo in ". $stack['file']. " " . $stack['line'];
            $logger->setCustomFile($log)->error($message);
            View::View("errors/".$stack['code']);

        } 

        return true;
    } 
}
