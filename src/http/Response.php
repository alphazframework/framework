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

class Response extends Message
{
    /**
     * __construct.
     *
     * Instantiate the response object
     *
     * @param (array) $config
     *
     * @since 3.0.0
     */
    public function __construct(array $config = [])
    {
        parent::__construct();
        // Check for config values and set defaults
        if (!isset($config['version'])) {
            $config['version'] = '1.1';
        }
        if (!isset($config['code'])) {
            $config['code'] = 200;
        }

        $this->setVersion($config['version'])
             ->withStatus($config['code']);

        if (!isset($config['reasonPhrase'])) {
            $config['reasonPhrase'] = self::$responseCodes[$config['code']];
        }
        if (!isset($config['headers']) || (isset($config['headers']) && !is_array($config['headers']))) {
            $config['headers'] = ['Content-Type' => 'text/html'];
        }
        if (!isset($config['body'])) {
            $config['body'] = null;
        }

        $this->setReasonPhrase($config['reasonPhrase'])
             ->setHeaders($config['headers'])
             ->setBody($config['body']);
    }

    /**
     * Get response message from code.
     *
     * @param (int) $code
     *
     * @since 3.0.0
     *
     * @return string
     */
    public static function getMessageFromCode($code)
    {
        if (!array_key_exists($code, self::$responseCodes)) {
            throw new \Exception('The header code '.$code.' is not valid.');
        }

        return self::$responseCodes[$code];
    }

    /**
     * Encode the body data.
     *
     * @param  (mixed) $body
     *         (string) $encode
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
                    throw new \Exception('Gzip compression is not available.');
                }
                $encodedBody = gzencode($body);
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzdeflate')) {
                    throw new \Exception('Deflate compression is not available.');
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
     * Decode the body data.
     *
     * @param  (mixed) $body
     *         (string) $encode
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
                    throw new \Exception('Gzip compression is not available.');
                }
                $decodedBody = gzinflate(substr($body, 10));
                break;

            // Deflate compression
            case 'deflate':
                if (!function_exists('gzinflate')) {
                    throw new \Exception('Deflate compression is not available.');
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
     * Is this response empty?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isEmpty()
    {
        return is_array($this->getStatusCode(), [204, 205, 304]);
    }

    /**
     * Is this response ok?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isOk()
    {
        return $this->getStatusCode() === 200;
    }

    /**
     * Is this response successful?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * Is this response redirect.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isRedirect()
    {
        return is_array($this->getStatusCode(), [301, 302, 303, 307, 308]);
    }

    /**
     * Is this response Forbidden?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isForbidden()
    {
        return $this->getStatusCode() === 403;
    }

    /**
     * Is this response not found?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isNotFound()
    {
        return $this->getStatusCode() === 404;
    }

    /**
     * Is this response Client error?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isClientError()
    {
        return $this->getStatusCode() >= 400 && $this->getStatusCode() < 500;
    }

    /**
     * Is this response Server error?.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isServertusCode()
    {
        return $this->getStatusCode() >= 500 && $this->getStatusCode() < 600;
    }

    /**
     * Get the response headers as a string.
     *
     * @param  (bool) $status
     * 		   (string) $eol
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHeadersAsString($status = true, $eol = "\n")
    {
        $headers = '';

        if ($status) {
            $headers = "HTTP/{$this->version} {$this->code} {$this->reasonPhrase}{$eol}";
        }

        foreach ($this->headers as $name => $value) {
            $headers .= "{$name}: {$value}{$eol}";
        }

        return $headers;
    }

    /**
     * Set the reasonPhrase.
     *
     * @param (float) $version
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setReasonPhrase($reasonPhrase = '')
    {
        $this->reasonPhrase = $reasonPhrase;

        return $this;
    }

    /**
     * Set the protocol version.
     *
     * @param (float) $version
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setVersion($version = 1.1)
    {
        $this->withProtocolVersion($version);

        return $this;
    }

    /**
     * Get the status code.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->code;
    }

    /**
     * Set the status code.
     *
     * @param (int) $code
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function withStatus($code = 200)
    {
        if (!array_key_exists($code, self::$responseCodes)) {
            throw new Exception('That header code '.$code.' is not allowed.');
        }

        $this->code = $code;
        $this->reasonPhrase = self::$responseCodes[$code];

        return $this;
    }

    /**
     * Set the response body.
     *
     * @param (mixed) $body
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setBody($body = null)
    {
        $this->withBody($body);

        return $this;
    }

    /**
     * Set SSL headers to fix file cache issues over SSL in certain browsers.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setSslHeaders()
    {
        $this->setHeader('Expires', 0);
        $this->setHeader('Cache-Control', 'private, must-revalidate');
        $this->setHeader('Pragma', 'cache');

        return $this;
    }

    /**
     * Send response and exit.
     *
     * @param (int) $code
     * 		  (array) $headers
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
     * Return entire response as a string.
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

        return $this->getHeadersAsString()."\n".$body;
    }
}