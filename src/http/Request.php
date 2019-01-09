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

namespace Zest\http;

class Request extends HTTP
{
    /**
     * Constructor.
     *
     * Instantiate the request object
     *
     * @param string $uri
     *
     * @since 3.0.0
     *
     * @param string $basePath
     */
    public function __construct($uri = null, $basePath = null)
    {
        $this->setRequestUri($uri, $basePath);

        $this->get = (isset($_GET)) ? $_GET : [];
        $this->post = (isset($_POST)) ? $_POST : [];
        $this->files = (isset($_FILES)) ? $_FILES : [];
        $this->cookie = (isset($_COOKIE)) ? $_COOKIE : [];
        $this->server = (isset($_SERVER)) ? $_SERVER : [];
        $this->env = (isset($_ENV)) ? $_ENV : [];

        if ($this->getRequestMethod()) {
            $this->parseData();
        }
        $this->headers = $this->getHeaders();
    }

    /**
     * Determine whether or not the request has FILES.
     *
     * @return bool
     */
    public function hasFiles()
    {
        return count($this->files) > 0;
    }

    /**
     * Determine whether or not the method is GET.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'GET');
    }

    /**
     * Determine whether or not the method is HEAD.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isHead()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'HEAD');
    }

    /**
     * Determine whether or not the method is POST.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'POST');
    }

    /**
     * Determine whether or not the method is PUT.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPut()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'PUT');
    }

    /**
     * Determine whether or not the method is DELETE.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isDelete()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'DELETE');
    }

    /**
     * Determine whether or not the method is TRACE.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isTrace()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'TRACE');
    }

    /**
     * Determine whether or not the method is OPTIONS.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isOptions()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'OPTIONS');
    }

    /**
     * Determine whether or not the method is CONNECT.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isConnect()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'CONNECT');
    }

    /**
     * Determine whether or not the method is PATCH.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isPatch()
    {
        return $this->getRequestMethod() && ($this->getRequestMethod() === 'PATCH');
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
     * Get scheme.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getScheme()
    {
        return ($this->isSecure()) ? 'https' : 'http';
    }

    /**
     * Get the base path.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Get the request URI.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Get the full request URI, including base path.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getFullRequestUri()
    {
        return $this->basePath.$this->requestUri;
    }

    /**
     * Get a path segment, divided by the forward slash,
     * where $i refers to the array key index, i.e.,
     *    0     1     2
     * /hello/world/page.
     *
     * @param int $i
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getSegment($i)
    {
        return (isset($this->segments[(int) $i])) ? $this->segments[(int) $i] : null;
    }

    /**
     * Get all path segments.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * Get a value from $_GET, or the whole array.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * Get a value from $_COOKIE, or the whole array.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string|array
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
     * Get a value from the request headers.
     *
     * @param string $key
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHeader($key)
    {
        return (isset($this->headers[$key])) ? $this->headers[$key] : null;
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
     * Set the base path.
     *
     * @param string $path
     *
     * @since 3.0.0
     *
     * @return Request
     */
    public function setBasePath($path = null)
    {
        $this->basePath = $path;

        return $this;
    }

    /**
     * Set the request URI.
     *
     * @param  $uri
     * 		   $basePath
     *
     * @since 3.0.0
     *
     * @return Request
     */
    public function setRequestUri($uri = null, $basePath = null)
    {
        if ($uri === null && $this->getRequestUrl()) {
            $uri = $this->getRequestUrl();
        }
        if (!empty($basePath)) {
            if (substr($uri, 0, (strlen($basePath) + 1)) == $basePath.'/') {
                $uri = substr($uri, (strpos($uri, $basePath) + strlen($basePath)));
            } elseif (substr($uri, 0, (strlen($basePath) + 1)) == $basePath.'?') {
                $uri = '/'.substr($uri, (strpos($uri, $basePath) + strlen($basePath)));
            }
        }

        if (($uri == '') || ($uri == $basePath)) {
            $uri = '/';
        }

        // Some slash clean up
        $this->requestUri = $uri;
        $docRoot = ($this->getDocumentRoot()) ? str_replace('\\', '/', $this->getDocumentRoot()) : null;
        $dir = str_replace('\\', '/', getcwd());

        if ($dir != $docRoot && strlen($dir) > strlen($docRoot)) {
            $realBasePath = str_replace($docRoot, '', $dir);
            if (substr($uri, 0, strlen($realBasePath)) == $realBasePath) {
                $this->requestUri = substr($uri, strlen($realBasePath));
            }
        }

        $this->basePath = ($basePath === null) ? str_replace($docRoot, '', $dir) : $basePath;

        if (strpos($this->requestUri, '?') !== false) {
            $this->requestUri = substr($this->requestUri, 0, strpos($this->requestUri, '?'));
        }

        if (($this->requestUri != '/') && strpos($this->requestUri, '/') !== false) {
            $uri = (substr($this->requestUri, 0, 1) == '/') ? substr($this->requestUri, 1) : $this->requestUri;
            $this->segments = explode('/', $uri);
        }

        return $this;
    }

    /**
     * Magic method to get a value from one of the server/environment variables.
     *
     * @param  $name
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'get':
                return $this->get;
                break;
            case 'post':
                return $this->post;
                break;
            case 'files':
                return $this->files;
                break;
            case 'put':
                return $this->put;
                break;
            case 'patch':
                return $this->patch;
                break;
            case 'delete':
                return $this->delete;
                break;
            case 'cookie':
                return $this->cookie;
                break;
            case 'server':
                return $this->server;
                break;
            case 'env':
                return $this->env;
                break;
            case 'parsed':
                return $this->parsedData;
                break;
            case 'raw':
                return $this->rawData;
                break;
            default:
                return;
        }
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
