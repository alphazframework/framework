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

class Response extends HTTP
{

    /**
     * __construct
     *
     * Instantiate the response object
     *
     * @param  $config
     *
     * @since 3.0.0
     *
     */
    public function __construct(array $config = [])
    {
        // Check for config values and set defaults
        if (!isset($config['version'])) {
            $config['version'] = '1.1';
        }
        if (!isset($config['code'])) {
            $config['code'] = 200;
        }

        $this->setVersion($config['version'])
             ->setCode($config['code']);

        if (!isset($config['message'])) {
            $config['message'] = self::$responseCodes[$config['code']];
        }
        if (!isset($config['headers']) || (isset($config['headers']) && !is_array($config['headers']))) {
            $config['headers'] = ['Content-Type' => 'text/html'];
        }
        if (!isset($config['body'])) {
            $config['body'] = null;
        }

        $this->setMessage($config['message'])
             ->setHeaders($config['headers'])
             ->setBody($config['body']);
    }
    /**
     * Get response message from code
     *
     * @param  $code
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function getMessageFromCode($code)
    {
        if (!array_key_exists($code, self::$responseCodes)) {
            throw new Exception('The header code ' . $code . ' is not valid.');
        }

        return self::$responseCodes[$code];
    }

    /**
     * Encode the body data
     *
     * @param   $body
     * 		    $encode
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function encodeBody($body, $encode = 'gzip')
    {
        switch ($encode) {
            // GZIP compression
            case 'gzip':
                if (!function_exists('gzencode')) {
                    throw new Exception('Gzip compression is not available.');
                }
                $encodedBody = gzencode($body);
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzdeflate')) {
                    throw new Exception('Deflate compression is not available.');
                }
                $encodedBody = gzdeflate($body);
                break;

            // Unknown compression
            default:
                $encodedBody = $body;

        }

        return $encodedBody;
    }

    /**
     * Decode the body data
     *
     * @param  $body
     * 		   $decode
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function decodeBody($body, $decode = 'gzip')
    {
        switch ($decode) {
            // GZIP compression
            case 'gzip':
                if (!function_exists('gzinflate')) {
                    throw new Exception('Gzip compression is not available.');
                }
                $decodedBody = gzinflate(substr($body, 10));
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzinflate')) {
                    throw new Exception('Deflate compression is not available.');
                }
                $zlibHeader = unpack('n', substr($body, 0, 2));
                $decodedBody = ($zlibHeader[1] % 31 == 0) ? gzuncompress($body) : gzinflate($body);
                break;

            // Unknown compression
            default:
                $decodedBody = $body;

        }

        return $decodedBody;
    }

    /**
     * Determine if the response is a success
     *
     * @since 3.0.0
     *
     * @return boolean
     */
    public function isSuccess()
    {
        $type = floor($this->code / 100);
        return (($type == 1) || ($type == 2) || ($type == 3));
    }

    /**
     * Determine if the response is a redirect
     *
     * @since 3.0.0
     *
     * @return boolean
     */
    public function isRedirect()
    {
        $type = floor($this->code / 100);
        return ($type == 3);
    }

    /**
     * Determine if the response is an error
     *
     * @since 3.0.0
     *
     * @return boolean
     */
    public function isError()
    {
        $type = floor($this->code / 100);
        return (($type == 4) || ($type == 5));
    }

    /**
     * Determine if the response is a client error
     *
     * @since 3.0.0
     *
     * @return boolean
     */
    public function isClientError()
    {
        $type = floor($this->code / 100);
        return ($type == 4);
    }

    /**
     * Determine if the response is a server error
     *
     * @since 3.0.0
     *
     * @return boolean
     */
    public function isServerError()
    {
        $type = floor($this->code / 100);
        return ($type == 5);
    }

    /**
     * Get the response version
     *
     * @since 3.0.0
     *
     * @return float
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the response code
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the response message
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the response body
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get the response headers
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get the response header
     *
     * @param $name
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHeader($name)
    {
        return (isset($this->headers[$name])) ? $this->headers[$name] : null;
    }

    /**
     * Get the response headers as a string
     *
     * @param  $status
     * 		   $eol
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHeadersAsString($status = true, $eol = "\n")
    {
        $headers = '';

        if ($status) {
            $headers = "HTTP/{$this->version} {$this->code} {$this->message}{$eol}";
        }

        foreach ($this->headers as $name => $value) {
            $headers .= "{$name}: {$value}{$eol}";
        }

        return $headers;
    }

    /**
     * Set the response version
     *
     * @param  float $version
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setVersion($version = 1.1)
    {
        if (($version == 1.0) || ($version == 1.1)) {
            $this->version = $version;
        }
        return $this;
    }

    /**
     * Set the response code
     *
     * @param  $code
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setCode($code = 200)
    {
        if (!array_key_exists($code, self::$responseCodes)) {
            throw new Exception('That header code ' . $code . ' is not allowed.');
        }

        $this->code    = $code;
        $this->message = self::$responseCodes[$code];

        return $this;
    }

    /**
     * Set the response message
     *
     * @param  string $message
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setMessage($message = null)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set the response body
     *
     * @param  $body
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setBody($body = null)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set a response header
     *
     * @param  $name
     * 	 	   $value
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Set response headers
     *
     * @param  array $headers
     * @throws Exception
     * @return Response
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->headers[$name] = $value;
        }

        return $this;
    }

    /**
     * Set SSL headers to fix file cache issues over SSL in certain browsers.
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function setSslHeaders()
    {
        $this->headers['Expires']       = 0;
        $this->headers['Cache-Control'] = 'private, must-revalidate';
        $this->headers['Pragma']        = 'cache';

        return $this;
    }

    /**
     * Send headers
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            throw new Exception('The headers have already been sent.');
        }

        header("HTTP/{$this->version} {$this->code} {$this->message}");
        foreach ($this->headers as $name => $value) {
            header($name . ": " . $value);
        }
    }

    /**
     * Send response
     *
     * @param  $code
     * 		   $headers
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function send($code = null, array $headers = null)
    {
        if ($code !== null) {
            $this->setCode($code);
        }
        if ($header !== null) {
            $this->setHeaders($headers);
        }

        $body = $this->body;

        if (array_key_exists('Content-Encoding', $this->headers)) {
            $body = self::encodeBody($body, $this->headers['Content-Encoding']);
            $this->headers['Content-Length'] = strlen($body);
        }

        $this->sendHeaders();
        echo $body;
    }

    /**
     * Send response and exit
     *
     * @param  $code
     * 		   $headers
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function sendAndExit($code = null, array $headers = null)
    {
        $this->send($code, $headers);
        exit();
    }

    /**
     * Magic method to get a value from the headers
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'headers':
                return $this->headers;
                break;
            default:
                return null;
        }
    }

    /**
     * Return entire response as a string
     *
     * @return string
     */
    public function __toString()
    {
        $body = $this->body;

        if (array_key_exists('Content-Encoding', $this->headers)) {
            $body = self::encodeBody($body, $this->headers['Content-Encoding']);
            $this->headers['Content-Length'] = strlen($body);
        }

        return $this->getHeadersAsString() . "\n" . $body;
    }

}
