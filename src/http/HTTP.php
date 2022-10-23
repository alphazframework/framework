<?php

/**
 * This file is part of the alphaz Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/alphazframework/framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 1.0.0
 *
 * @license MIT
 */

namespace alphaz\http;

abstract class HTTP extends Headers
{
    // /*Response*/
    use StatusCode;
    use ValidProtocolVersions;

    /*Request*/
    /**
     * Request URI.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $requestUri = null;

    /**
     * Path segments.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $segments = [];

    /**
     * Base path.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $basePath = null;

    /**
     * Headers.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Raw data.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $rawData = null;

    /**
     * Parsed data.
     *
     * @since 1.0.0
     *
     * @var mixed
     */
    protected $parsedData = null;

    /**
     * GET array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $get = [];

    /**
     * POST array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $post = [];

    /**
     * FILES array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $files = [];

    /**
     * PUT array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $put = [];

    /**
     * PATCH array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $patch = [];

    /**
     * DELETE array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $delete = [];

    /**
     * SESSION array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $session = [];

    /**
     * COOKIE array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $cookie = [];

    /**
     * SERVER array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $server = [];

    /**
     * ENV array.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $env = [];

    /* Response */
    /**
     * HTTP version.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $version = '1.1';

    /**
     * Protocol.
     *
     * @since 1.0.0
     *
     * @var int
     */
    protected $code = null;

    /**
     * reasonPhrase.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $reasonPhrase = null;

    /**
     * Uri scheme (without "://" suffix).
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $scheme = '';

    /**
     * Uri user.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $user = '';

    /**
     * Uri password.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $password = '';

    /**
     * Uri host.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $host = '';

    /**
     * Uri port number.
     *
     * @since 1.0.0
     *
     * @var null|int
     */
    protected $port;

    /**
     * Uri path.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $path = '';

    /**
     * Uri query string (without "?" prefix).
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $query = '';

    /**
     * Uri fragment string (without "#" prefix).
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $fragment = '';

    /**
     * Response body.
     *
     * @since 1.0.0
     *
     * @var string
     */
    protected $body = null;

    /**
     * __construct.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get a value from $_SERVER['REQUEST_METHOD'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'] ?? false;
    }

    /**
     * Get a value from $_SERVER['REQUEST_URI'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getRequestUrl()
    {
        return $_SERVER['REQUEST_URI'] ?? false;
    }

    /**
     * Get a value from $_SERVER['CONTENT_TYPE'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getContentType()
    {
        return $_SERVER['CONTENT_TYPE'] ?? false;
    }

    /**
     * Get a value from $_SERVER['QUERY_STRING'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getQueryString()
    {
        return $_SERVER['QUERY_STRING'] ?? false;
    }

    /**
     * Get a value from $_SERVER['SERVER_PORT'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getServerPort()
    {
        return $_SERVER['SERVER_PORT'] ?? false;
    }

    /**
     * Get a value from $_SERVER['DOCUMENT_ROOT'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getDocumentRoot()
    {
        return $_SERVER['DOCUMENT_ROOT'] ?? false;
    }

    /**
     * Get a value from $_SERVER['HTTP_HOST'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getHost()
    {
        return $_SERVER['HTTP_HOST'] ?? false;
    }

    /**
     * Get a value from $_SERVER['SERVER_NAME'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getServerName()
    {
        return $_SERVER['SERVER_NAME'] ?? false;
    }

    /**
     * Get a value from $_SERVER['HTTP'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function gethttp()
    {
        return $_SERVER['HTTP'] ?? false;
    }

    /**
     * Get a value from $_SERVER['HTTPS'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function gethttps()
    {
        return $_SERVER['HTTPS'] ?? false;
    }

    /**
     * Get a value from $_SERVER['PHP_SELF'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getSelf()
    {
        return $_SERVER['PHP_SELF'] ?? false;
    }

    /**
     * Get a value from $_SERVER['HTTP_REFERER'].
     *
     * @since 1.0.0
     *
     * @return bool|array
     */
    public function getReference()
    {
        return $_SERVER['HTTP_REFERER'] ?? false;
    }
}
