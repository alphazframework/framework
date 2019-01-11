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

abstract class HTTP
{
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
     * Response codes & messages.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected static $responseCodes = [
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];
    /**
     * HTTP version.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $version = '1.1';

    /**
     * Response code.
     *
     * @since 3.0.0
     *
     * @var int
     */
    protected $code = null;

    /**
     * Response message.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $message = null;

    /**
     * Response body.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $body = null;

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
     * Get a headers.
     *
     * @since 3.0.0
     *
     * @return bool|array
     */
    public function getHeaders()
    {
        return getallheaders();
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
