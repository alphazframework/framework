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

abstract class HTTP extends Headers
{
    // /*Response*/
    use StatusCode,ValidProtocolVersions;

    /*Request*/
    /**
     * Request URI.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $requestUri = null;

    /**
     * Path segments.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $segments = [];

    /**
     * Base path.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $basePath = null;

    /**
     * Headers.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Raw data.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $rawData = null;

    /**
     * Parsed data.
     *
     * @since 3.0.0
     *
     * @var mixed
     */
    protected $parsedData = null;

    /**
     * GET array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $get = [];

    /**
     * POST array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $post = [];

    /**
     * FILES array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $files = [];

    /**
     * PUT array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $put = [];

    /**
     * PATCH array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $patch = [];

    /**
     * DELETE array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $delete = [];

    /**
     * COOKIE array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $cookie = [];

    /**
     * SERVER array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $server = [];

    /**
     * ENV array.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $env = [];

    /* Response */
    /**
     * HTTP version.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $version = '1.1';

    /**
     * Protocol.
     *
     * @since 3.0.0
     *
     * @var int
     */
    protected $code = null;

    /**
     * reasonPhrase.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $reasonPhrase = null;

    /**
     * Uri scheme (without "://" suffix).
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $scheme = '';

    /**
     * Uri user.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $user = '';

    /**
     * Uri password.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $password = '';

    /**
     * Uri host.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $host = '';

    /**
     * Uri port number.
     *
     * @since 3.0.0
     *
     * @var null|int
     */
    protected $port;

    /**
     * Uri path.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $path = '';

    /**
     * Uri query string (without "?" prefix).
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $query = '';

    /**
     * Uri fragment string (without "#" prefix).
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $fragment = '';

    /**
     * Response body.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $body = null;

    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get a value from $_SERVER['REQUEST_METHOD'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getRequestMethod()
    {
        return (isset($_SERVER['REQUEST_METHOD'])) ? $_SERVER['REQUEST_METHOD'] : false;
    }

    /**
     * Get a value from $_SERVER['REQUEST_URI'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getRequestUrl()
    {
        return (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : false;
    }

    /**
     * Get a value from $_SERVER['CONTENT_TYPE'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getContentType()
    {
        return (isset($_SERVER['CONTENT_TYPE'])) ? $_SERVER['CONTENT_TYPE'] : false;
    }

    /**
     * Get a value from $_SERVER['QUERY_STRING'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getQueryString()
    {
        return (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : false;
    }

    /**
     * Get a value from $_SERVER['SERVER_PORT'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getServerPort()
    {
        return (isset($_SERVER['SERVER_PORT'])) ? $_SERVER['SERVER_PORT'] : false;
    }

    /**
     * Get a value from $_SERVER['DOCUMENT_ROOT'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getDocumentRoot()
    {
        return (isset($_SERVER['DOCUMENT_ROOT'])) ? $_SERVER['DOCUMENT_ROOT'] : false;
    }

    /**
     * Get a value from $_SERVER['HTTP_HOST'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getHost()
    {
        return (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : false;
    }

    /**
     * Get a value from $_SERVER['SERVER_NAME'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getServerName()
    {
        return (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : false;
    }

    /**
     * Get a value from $_SERVER['HTTP'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function gethttp()
    {
        return (isset($_SERVER['HTTP'])) ? $_SERVER['HTTP'] : false;
    }

    /**
     * Get a value from $_SERVER['HTTPS'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function gethttps()
    {
        return (isset($_SERVER['HTTPS'])) ? $_SERVER['HTTPS'] : false;
    }

    /**
     * Get a value from $_SERVER['PHP_SELF'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getSelf()
    {
        return (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : false;
    }

    /**
     * Get a value from $_SERVER['HTTP_REFERER'].
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getReference()
    {
        return (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : false;
    }
}