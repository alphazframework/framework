<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http\Clients;

class CURL extends AbstractClient
{
    /**
     * __construct.
     *
     * @param (string) $url
     *                      (string) $method
     *                      (array) $options
     *
     * @since 3.0.0
     */
    public function __construct($url, $method = 'GET', array $options = null)
    {
        if (!function_exists('curl_init')) {
            throw new \Exception('Error: cURL is not available.');
        }
        $this->resource = curl_init();

        $this->setUrl($url);
        $this->setMethod($method);
        $this->setOption(CURLOPT_URL, $this->url);
        $this->setOption(CURLOPT_HEADER, true);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        if ($options !== null) {
            $this->setOptions($options);
        }
    }

    /**
     * Set the method.
     *
     * @param (string) $method
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setMethod($method)
    {
        parent::setMethod($method);
        if ($method !== 'GET') {
            switch ($method) {
                case 'POST':
                    $this->setOption(CURLOPT_POST, true);
                    break;
                default:
                    $this->setOption(CURLOPT_CUSTOMREQUEST, $this->method);
                    break;
            }
        }

        return $this;
    }

    /**
     * Return cURL resource (alias to $this->getResource()).
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function curl()
    {
        return $this->resource;
    }

    /**
     * Create and open cURL resource.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function open()
    {
        $url = $this->url;
        $headers = [];

        // Set query data if there is any
        if (count($this->fields) > 0) {
            if ($this->method == 'GET') {
                $url = $this->options[CURLOPT_URL].'?'.$this->getQuery();
                $this->setOption(CURLOPT_URL, $url);
            } else {
                if (isset($this->requestHeaders['Content-Type']) && ($this->requestHeaders['Content-Type'] != 'multipart/form-data')) {
                    $this->setOption(CURLOPT_POSTFIELDS, $this->getQuery());
                    $this->setRequestHeader('Content-Length', $this->getQueryLength());
                } else {
                    $this->setOption(CURLOPT_POSTFIELDS, $this->fields);
                }
                $this->setOption(CURLOPT_POSTFIELDS, $this->fields);
                $this->setOption(CURLOPT_URL, $url);
            }
        }

        if ($this->hasRequestHeaders()) {
            foreach ($this->requestHeaders as $header => $value) {
                $headers[] = $header.': '.$value;
            }
            $this->setOption(CURLOPT_HTTPHEADER, $headers);
        }

        $this->response = curl_exec($this->resource);

        if ($this->response === false) {
            $this->throwError('Error: '.curl_errno($this->resource).' => '.curl_error($this->resource).'.');
        }

        return $this;
    }

    /**
     * Set curl session option.
     *
     * @param (mixed) $option
     *                        (mixed) $value
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
        curl_setopt($this->resource, $option, $value);

        return $this;
    }

    /**
     * Set curl session options.
     *
     * @param (array) $options
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setOptios($options)
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
        curl_setopt_array($this->resource, $options);

        return $this;
    }

    /**
     * Set curl return header.
     *
     * @param (bool) $header
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setReturnHeader($header = true)
    {
        $this->setOption(CURLOPT_HEADER, (bool) $header);

        return $this;
    }

    /**
     * Set curl return tranfer header.
     *
     * @param (bool) $header
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setReturnTransfer($header = true)
    {
        $this->setOption(CURLOPT_RETURNTRANSFER, (bool) $header);

        return $this;
    }

    /**
     * Set curl return header.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isReturnHeader()
    {
        return isset($this->options[CURLOPT_HEADER]) && ($this->options[CURLOPT_HEADER] == true);
    }

    /**
     * Set curl return tranfer header.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function isReturnTransfer()
    {
        return isset($this->options[CURLOPT_RETURNTRANSFER]) && ($this->options[CURLOPT_RETURNTRANSFER] == true);
    }

    /**
     * Get curl session option.
     *
     * @param (mixes) $option
     *
     * @since 3.0.0
     *
     * @return mixes
     */
    public function getOption($option)
    {
        return (isset($this->options[$option])) ? $this->options[$option] : false;
    }

    /**
     * Get curl last session info.
     *
     * @param (mixes) $option
     *
     * @since 3.0.0
     *
     * @return mixes
     */
    public function getInfo($option = null)
    {
        return ($option !== null) ? curl_getinfo($this->resource, $option) : curl_getinfo($this->resource);
    }

    /**
     * Method to send the request and get the response.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function send()
    {
        $this->open();

        if ($this->response === false) {
            throw new \Exception('Error: '.curl_errno($this->resource).' => '.curl_error($this->resource).'.');
        }
        // If the CURLOPT_RETURNTRANSFER option is set to true, get the response body and parse the headers.
        if (isset($this->options[CURLOPT_RETURNTRANSFER]) && ($this->options[CURLOPT_RETURNTRANSFER] == true)) {
            $headerSize = $this->getInfo(CURLINFO_HEADER_SIZE);
            if ($this->options[CURLOPT_HEADER]) {
                $this->responseHeader = substr($this->response, 0, $headerSize);
                $this->body = substr($this->response, $headerSize);
                $this->parseResponseHeaders();
            } else {
                $this->body = $this->response;
            }
        }

        if (array_key_exists('Content-Encoding', $this->responseHeaders)) {
            $this->decodeBody();
        }
    }

    /**
     * Return the cURL version.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function version()
    {
        return curl_version();
    }

    /**
     * Close the cURL connection.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function close()
    {
        if ($this->hasResource()) {
            curl_close($this->resource);
        }
    }

    /**
     * Parse headers.
     *
     * @since 3.0.0
     *
     * @return void
     */
    protected function parseResponseHeaders()
    {
        if ($this->responseHeader !== null) {
            $headers = explode("\n", $this->responseHeader);
            foreach ($headers as $header) {
                if (strpos($header, 'HTTP') !== false) {
                    $this->version = substr($header, 0, strpos($header, ' '));
                    $this->version = substr($this->version, (strpos($this->version, '/') + 1));
                    preg_match('/\d\d\d/', trim($header), $match);
                    $this->code = $match[0];
                    $this->message = trim(str_replace('HTTP/'.$this->version.' '.$this->code.' ', '', $header));
                } elseif (strpos($header, ':') !== false) {
                    $name = substr($header, 0, strpos($header, ':'));
                    $value = substr($header, strpos($header, ':') + 1);
                    $this->responseHeaders[trim($name)] = trim($value);
                }
            }
        }
    }
}
