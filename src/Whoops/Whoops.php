<?php

/**
 * This file is a part of Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Whoops;

use Zest\Common\Logger\Logger;
use Zest\Common\Version;
use Zest\http\Request;
use Zest\Site\Site;
use Zest\UserInfo\UserInfo;
use Zest\View\View;

class Whoops
{
    /**
     * Store the errors stack.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $stack = [];

    /**
     * A list of known editor strings.
     *
     * @since 3.0.0
     *
     * @var array
     */
    private $editors = [
        'sublime'  => 'subl://open?url=file://::file&line=::line',
    ];

    /**
     * Current editor that to be use.
     *
     * @since 3.0.0
     *
     * @var string
     */
    public $setEditor = '';

    /**
     * __construct.
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
     * expection handler.
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
            $e->getTraceAsString(),
            $e->getTrace()
        );

        return $this->render();
    }

    /**
     * Get the requests details.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getRequests()
    {
        $request = new Request();
        $requests = [
            'baseUrl'      => site_base_url(),
            'url'          => Site::siteUrl(),
            'method'       => $request->getRequestMethod(),
            'headers'      => $request->getHeaders(),
            'query_string' => $request->getQueryString(),
            'body'         => $request->getBody(),
            'files'        => $request->getFiles(),
            'session'      => $request->getSession(),
            'cookies'      => $request->getCookie(),
            'ip'           => (new UserInfo())->ip(),
            'user_agent'   => UserInfo::agent(),
        ];

        return $requests;
    }

    /**
     * Get the Environment details.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getEnvironment()
    {
        $environment = [
            'ZestVersion'  => Version::VERSION,
            'PHPVersion'   => \PHP_VERSION,
        ];

        return $environment;
    }

    /**
     * Get the solution.
     *
     * @todo
     *
     * @return array
     */
    public function getSolution()
    {
        //TODO
    }

    /**
     * Get the editor uri.
     *
     * @param string $key editor name
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getEditor($key)
    {
        return (isset($this->editors[$key])) ? $this->editors[$key] : null;
    }

    /**
     * Get the editor uri.
     *
     * @param string $key editor name
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function setEditor($key)
    {
        $this->setEditor = (isset($this->editors[$key])) ? $key : null;
    }

    /**
     * Appen the editor.
     *
     * @param string $key editor name
     * @param string $uri valid url string pattern
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function appendEditor($key, $uri) :self
    {
        $arr = [$key => $uri];
        $merge = array_merge($arr, $this->editors);
        $this->editors = $merge;

        return $this;
    }

    /**
     * Error handler.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function error($code, $msg, $file, $line)
    {
        $this->setParams($code, $msg, $file, $line, '', []);

        return $this->render();
    }

    /**
     * Set the error item to stack.
     *
     * @param int    $code
     * @param string $msg
     * @param string $file
     * @param int    $line
     * @param string $trace
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    protected function setParams($code, $msg, $file, $line, $trace, $traces)
    {
        return $this->stack = [
            'message'     => $msg,
            'file'        => $file,
            'line'        => $line,
            'code'        => ($code === 0) ? 404 : $code,
            'trace'       => $trace,
            'traces'      => $traces,
            'previewCode' => '',
            'editor'      => $this->setEditor,
            'editorUri'   => $this->getEditor($this->setEditor),
            'requests'    => $this->getRequests(),
            'environment' => $this->getEnvironment(),
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
            $end = $_line + 15;
        } else {
            $start = $_line;
            $end = $line;
        }
        for ($i = $start; $i <= $end; $i++) {
            if (!isset($file[$i])) {
                break;
            }
            $text = htmlentities($file[$i]);
            if ($i === $_line) {
                $this->stack['previewCode'] .=
                    "<span style='background:red' class='line'>".($i + 1).'</span>'.
                    "<span style=''>".$text.'</span><br>';
                continue;
            }
            $this->stack['previewCode'] .=
                "<span class='line'>".($i + 1).'</span>'.
                '<span>'.$text.'</span><br>';
        }
    }

    /**
     * Rander the error.
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function render()
    {
        $this->getPreviewCode();
        $stack = $this->stack;
        if (__config('app.show_errors') === true) {
            $file = __DIR__.'/views/view.php';
            if (file_exists($file)) {
                require $file;
            }
        } else {
            $logger = new Logger();
            $log = date('Y-m-d').'.log';
            $message = 'Message: '.$stack['message'];
            $message .= "\n Stack trace: ".$stack['trace'];
            $message .= "\n Thrwo in ".$stack['file'].' '.$stack['line'];
            $logger->setCustomFile($log)->error($message);
            View::View('errors/'.$stack['code']);
        }

        return true;
    }
}
