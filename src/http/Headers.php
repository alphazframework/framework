<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Muhammad Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/Muhammadumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http;

abstract class Headers extends Clients\Client
{
    /**
     * Get the headers.
     *
     * @since 3.0.0
     */
    public function __construct()
    {
        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } else {
            foreach ($_SERVER as $key => $value) {
                if (substr($key, 0, 5) == 'HTTP_') {
                    $key = ucfirst(strtolower(str_replace('HTTP_', '', $key)));
                    if (strpos($key, '_') !== false) {
                        $ary = explode('_', $key);
                        foreach ($ary as $k => $v) {
                            $ary[$k] = ucfirst(strtolower($v));
                        }
                        $key = implode('-', $ary);
                    }
                    $headers[$key] = $value;
                }
            }
        }
        $headers = array_change_key_case($headers, CASE_LOWER);

        $this->headers = $headers;
    }

    /**
     * append new header.
     *
     * @param (string) $key   The header key.
     * @param (string) $value The header value.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function setHeader($key, $value)
    {
        $this->headers[$this->normalizeKey($key)] = $value;
    }

    /**
     * Set response headers.
     *
     * @param (array) $headers
     *
     * @return object
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }

        return $this;
    }

    /**
     * Update existing header.
     *
     * @param (string) $key   The header key
     * @param (string) $value The new header value
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function update($key, $value)
    {
        if (!empty($this->get($this->normalizeKey($key)))) {
            $this->headers[$this->normalizeKey($key)] = $value;
        }
    }

    /**
     * Get all headers.
     *
     * @since 3.0.0
     *
     * @return bool|string
     */
    public function gets()
    {
        return $this->headers;
    }

    /**
     * Determine if header exists.
     *
     * @param (string) $key The header key
     *
     * @since 3.0.0
     *
     * @return bool|string
     */
    public function get($key)
    {
        return $this->headers[$this->normalizeKey($key)];
    }

    /**
     * Get the header by key.
     *
     * @param (string) $key The header key
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function has($key)
    {
        return (isset($this->headers[$this->normalizeKey($key)])) ? true : false;
    }

    /**
     * Remove the header by key.
     *
     * @param (string) $key The header key
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function remove($key)
    {
        unset($this->headers[$key]);
    }

    /**
     * Normalize header name.
     *
     * @param (string) $key The case-insensitive header name
     *
     * @return string
     */
    public function normalizeKey($key)
    {
        $key = strtr(strtolower($key), '_', '-');

        return $key;
    }

    /**
     * Send response.
     *
     * @param (int)   $code     Status code.
     * @param (array) $headers  Headers.
     * @param (bool)  $compress Content compression.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function send($code = null, array $headers = null, $compress = false)
    {
        if ($code !== null) {
            $this->withStatus($code);
        }
        if ($headers !== null) {
            $this->setHeaders($headers);
        }

        $body = $this->body;
        $this->headers['Content-Length'] = strlen($body);
        
        if ($compress === true) {
            $encoding = '';
            if (preg_match('/ *gzip *,?/', $this->headers['accept-encoding'])) {
               $encoding = 'gzip';
            } elseif(preg_match('/ *deflate *,?/', $this->headers['accept-encoding'])) {
                $encoding = 'deflate';       
            }
            (!empty($encoding)) ? $this->headers['Content-Encoding']  = $encoding : null;
            $body = static::encodeBody($body, $encoding);
        }    
        
        $this->sendHeaders();
        echo $body;
    }

    /**
     * Send headers.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function sendHeaders()
    {
        if (headers_sent()) {
            throw new \Exception('The headers have already been sent.');
        }

        header("HTTP/{$this->version} {$this->code} {$this->reasonPhrase}");
        foreach ($this->headers as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    header($key.': '.$val);
                }
            } else {
                header($name.': '.$value);
            }
        }
    }
}
