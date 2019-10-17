<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http;

class Request extends Uri
{
    /**
     * Constructor.
     *
     * Instantiate the request object
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        parent::__construct();
        $this->get = (isset($_GET)) ? $_GET : [];
        $this->post = (isset($_POST)) ? $_POST : [];
        $this->files = (isset($_FILES)) ? $_FILES : [];
        $this->session = (isset($_SESSION)) ? $_SESSION : [];
        $this->cookie = (isset($_COOKIE)) ? $_COOKIE : [];
        $this->server = (isset($_SERVER)) ? $_SERVER : [];
        $this->env = (isset($_ENV)) ? $_ENV : [];

        if ($this->getRequestMethod()) {
            $this->parseData();
        }
    }

    /**
     * Does this request use a given method?
     *
     * @param (string) $method HTTP method
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isMethod($method)
    {
        return $this->getRequestMethod() === $method;
    }

    /**
     * Determine whether or not the request has FILES.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasFiles()
    {
        return count($this->files) > 0;
    }

    /**
     * Is this an GET request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->isMethod('GET');
    }

    /**
     * Is this an HEAD request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isHead()
    {
        return $this->isMethod('HEAD');
    }

    /**
     * Is this an POST request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }

    /**
     * Is this an PUT request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPut()
    {
        return $this->isMethod('PUT');
    }

    /**
     * Is this an DELETE request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isDelete()
    {
        return $this->isMethod('DELETE');
    }

    /**
     * Is this an TRACE request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isTrace()
    {
        return $this->isMethod('TRACE');
    }

    /**
     * Is this an OPTIONS request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isOptions()
    {
        return $this->isMethod('OPTIONS');
    }

    /**
     * Is this an CONNEXT request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isConnect()
    {
        return $this->isMethod('CONNECT');
    }

    /**
     * Is this an PATH request.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPatch()
    {
        return $this->isMethod('PATCH');
    }

    /**
     * Return whether or not the request is secure.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSecure()
    {
        return ($this->gethttps() || $this->getServerPort() && $this->getServerPort() == '443') ? true : false;
    }

    /**
     * Is this an XHR request?
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isXhr()
    {
        return strtolower($this->getHeader('x-requested-with')) === 'xmlhttprequest';
    }

    /**
     * Get a value from $_GET, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getQuery($key = null)
    {
        if ($key === null) {
            return $this->get;
        } else {
            return (isset($this->get[$key])) ? $this->get[$key] : null;
        }
    }

    /**
     * Get a value from $_POST, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getPost($key = null)
    {
        if ($key === null) {
            return $this->post;
        } else {
            return (isset($this->post[$key])) ? $this->post[$key] : null;
        }
    }

    /**
     * Get a value from $_FILES, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getFiles($key = null)
    {
        if ($key === null) {
            return $this->files;
        } else {
            return (isset($this->files[$key])) ? $this->files[$key] : null;
        }
    }

    /**
     * Get a value from PUT query data, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getPut($key = null)
    {
        if ($key === null) {
            return $this->put;
        } else {
            return (isset($this->put[$key])) ? $this->put[$key] : null;
        }
    }

    /**
     * Get a value from PATCH query data, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getPatch($key = null)
    {
        if ($key === null) {
            return $this->patch;
        } else {
            return (isset($this->patch[$key])) ? $this->patch[$key] : null;
        }
    }

    /**
     * Get a value from DELETE query data, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getDelete($key = null)
    {
        if ($key === null) {
            return $this->delete;
        } else {
            return (isset($this->delete[$key])) ? $this->delete[$key] : null;
        }
    }

    /**
     * Get a value from $_SESSION, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getSession($key = null)
    {
        if ($key === null) {
            return $this->session;
        } else {
            return (isset($this->session[$key])) ? $this->session[$key] : null;
        }
    }

    /**
     * Get a value from $_COOKIE, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getCookie($key = null)
    {
        if ($key === null) {
            return $this->cookie;
        } else {
            return (isset($this->cookie[$key])) ? $this->cookie[$key] : null;
        }
    }

    /**
     * Get a value from $_SERVER, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getServer($key = null)
    {
        if ($key === null) {
            return $this->server;
        } else {
            return (isset($this->server[$key])) ? $this->server[$key] : null;
        }
    }

    /**
     * Get a value from $_ENV, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getEnv($key = null)
    {
        if ($key === null) {
            return $this->env;
        } else {
            return (isset($this->env[$key])) ? $this->env[$key] : null;
        }
    }

    /**
     * Get a value from parsed data, or the whole array.
     *
     * @param (string) $key
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getParsedData($key = null)
    {
        $result = null;

        if ($this->parsedData !== null && is_array($this->parsedData)) {
            if (null === $key) {
                $result = $this->parsedData;
            } else {
                $result = (isset($this->parsedData[$key])) ? $this->parsedData[$key] : null;
            }
        }

        return $result;
    }

    /**
     * Get the raw data.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Parse any data that came with the request.
     *
     * @since 3.0.0
     *
     * @return void
     */
    protected function parseData()
    {
        if (strtoupper($this->getRequestMethod()) == 'GET') {
            $this->rawData = ($this->getQueryString()) ? rawurldecode($this->getQueryString()) : null;
        } else {
            $input = fopen('php://input', 'r');
            while ($data = fread($input, 1024)) {
                $this->rawData .= $data;
            }
        }

        // If the content-type is JSON
        if ($this->getQueryString() && stripos($this->getQueryString(), 'json') !== false) {
            $this->parsedData = json_decode($this->rawData, true);
        // Else, if the content-type is XML
        } elseif ($this->getContentType() && stripos($this->getContentType(), 'xml') !== false) {
            $matches = [];
            preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $this->rawData, $matches);

            foreach ($matches[0] as $match) {
                $strip = str_replace(
                    ['<![CDATA[', ']]>', '<', '>'],
                    ['', '', '&lt;', '&gt;'],
                    $match
                );
                $this->rawData = str_replace($match, $strip, $this->rawData);
            }

            $this->parsedData = json_decode(json_encode((array) simplexml_load_string($this->rawData)), true);
        // Else, default to a regular URL-encoded string
        } else {
            switch (strtoupper($this->getRequestMethod())) {
                case 'GET':
                    $this->parsedData = $this->get;
                    break;

                case 'POST':
                    $this->parsedData = $this->post;
                    break;
                default:
                    if ($this->getContentType() && strtolower($this->getContentType()) == 'application/x-www-form-urlencoded') {
                        parse_str($this->rawData, $this->parsedData);
                    }
            }
        }
        switch (strtoupper($this->getRequestMethod())) {
            case 'PUT':
                $this->put = $this->parsedData;
                break;

            case 'PATCH':
                $this->patch = $this->parsedData;
                break;

            case 'DELETE':
                $this->delete = $this->parsedData;
                break;
        }
    }
}
