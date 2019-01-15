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

namespace Zest\http\Clients;

abstract class AbstractClient
{
    /**
     * Client resource object.
     *
     * @since 3.0.0
     *
     * @var object
     */
    protected $resource = '';

    /**
     * URL.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $url = '';

    /**
     * Method.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $method = '';

    /**
     * Fields.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Query.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $query = '';

    /**
     * Request headers.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $requestHeaders = [];

    /**
     * HTTP version from response.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $version = '';

    /**
     * Response code.
     *
     * @since 3.0.0
     *
     * @var int
     */
    protected $code;

    /**
     * Response message.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $message = '';

    /**
     * Raw response string.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $response = '';

    /**
     * Raw response header.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $responseHeader = '';

    /**
     * Response headers.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $responseHeaders = [];

    /**
     * Response body.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $body = '';

    /**
     * CURL options.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $options = [];

    /**
     * Stream context.
     *
     * @since 3.0.0
     *
     * @var resource
     */
    protected $context = null;

    /**
     * Stream context options.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $contextOptions = [];

    /**
     * Stream context parameters.
     *
     * @since 3.0.0
     *
     * @var array
     */
    protected $contextParams = [];

    /**
     * HTTP Response Headers.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $httpResponseHeaders = null;

    /**
     * Stream mode.
     *
     * @since 3.0.0
     *
     * @var string
     */
    protected $mode = 'r';

    /**
     * Set the URL.
     *
     * @param (string) $url
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
        $valid = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS', 'TRACE', 'CONNECT'];
        $method = strtoupper($method);

        if (!in_array($method, $valid)) {
            throw new \Exception('Error: That request method is not valid.');
        }
        $this->method = $method;

        return $this;
    }

    /**
     * Get the method.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the fields.
     *
     * @param (string) $name
     *                       (string) $value
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setField($name, $value)
    {
        $this->fields[$name] = $value;

        return $this;
    }

    /**
     * Set fields.
     *
     * @param (array) $fields
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $name => $value) {
            $this->setField($name, $value);
        }

        $this->prepareQuery();

        return $this;
    }

    /**
     * Get a field.
     *
     * @param (string) $name name of field
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getField($name)
    {
        return (isset($this->fields[$name])) ? $this->fields[$name] : false;
    }

    /**
     * Remove a fuekd.
     *
     * @param (string) $name name of field
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function getFields($name)
    {
        if (isset($this->fields[$name])) {
            unset($this->fields[$name]);
        }

        $this->prepareQuery();

        return $this;
    }

    /**
     * Prepare the HTTP query.
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function prepareQuery()
    {
        $this->query = http_build_query($this->fields);

        return $this;
    }

    /**
     * Get the HTTP query.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Get HTTP query length.
     *
     * @param (bool) $mb
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getQueryLength($mb = true)
    {
        return ($mb) ? mb_strlen($this->query) : strlen($this->query);
    }

    /**
     * Set a request header.
     *
     * @param (string) $name
     * @param (string) $value
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setRequestHeader($name, $value)
    {
        $this->requestHeaders[$name] = $value;

        return $this;
    }

    /**
     * Set all request headers.
     *
     * @param (arryay) $headers
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setRequestHeaders(array $headers)
    {
        $this->requestHeaders = $headers;

        return $this;
    }

    /**
     * Get a request header.
     *
     * @param (string) $name
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getRequestHeader($name)
    {
        return (isset($this->requestHeaders[$name])) ? $this->requestHeaders[$name] : null;
    }

    /**
     * Get all request headers.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }

    /**
     * Determine if there are request headers.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasRequestHeaders()
    {
        return count($this->requestHeaders) > 0;
    }

    /**
     * Get a response header.
     *
     * @param (string) $name
     *
     * @since 3.0.0
     *
     * @return mixed
     */
    public function getResponseHeader($name)
    {
        return (isset($this->responseHeaders[$name])) ? $this->responseHeaders[$name] : null;
    }

    /**
     * Get all response headers.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Determine if there are response headers.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasResponseHeaders()
    {
        return count($this->responseHeaders) > 0;
    }

    /**
     * Get raw response header.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getRawResponseHeader()
    {
        return $this->responseHeader;
    }

    /**
     * Get the response body.
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
     * Get the response code.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the response HTTP version.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHttpVersion()
    {
        return $this->version;
    }

    /**
     * Get the response HTTP message.
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
     * Get the raw response.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Determine whether or not resource is available.
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasResource()
    {
        return is_resource($this->resource);
    }

    /**
     * Get the resource.
     *
     * @since 3.0.0
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Decode the body.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function decodeBody()
    {
        $this->body = Response::decodeBody($this->body, $this->responseHeaders['Content-Encoding']);
    }

    /**
     * Create and open the client resource.
     *
     * @since 3.0.0
     *
     * @return AbstractClient
     */
    abstract public function open();

    /**
     * Method to send the request and get the response.
     *
     * @since 3.0.0
     *
     * @return void
     */
    abstract public function send();

    /**
     * Close the client resource.
     *
     * @since 3.0.0
     *
     * @return void
     */
    abstract public function close();
}
