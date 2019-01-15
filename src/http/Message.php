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

class Message extends HTTP
{
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
     * Get the protocol version.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->version;
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * @param (string) $version valid Protocol version
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function withProtocolVersion($version)
    {
        if (!isset(self::$validProtocolVersions[$version])) {
            throw new \InvalidArgumentException('Invalid HTTP version. Must be one of: '.implode(', ', array_keys(self::$validProtocolVersions)), 500);
        }
        $this->version = $version;

        return $this;
    }

    /**
     * Get all message headers value.
     *
     * @since 3.0.0
     *
     * @return void
     */
    public function getHeaders()
    {
        return $this->gets();
    }

    /**
     * Determine headers is exists.
     *
     * @param (string) $name header field/key name
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function hasHeader($name)
    {
        return $this->has($name);
    }

    /**
     * Get the header by key/name.
     *
     * @param (string) $name header field/key name
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHeader($name)
    {
        return $this->get($name);
    }

    /**
     * Get a comma-separated string of the values for a single header.
     *
     * @param (string) $name header field/key name
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getHeaderLine($name)
    {
        return implode(',', $this->get($name));
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * @param (string) $name header field/key name
     *        (string) $value header value
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function withHeader($name, $value)
    {
        $this->update($name, $value);

        return $this;
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * @param (string) $name header field/key name
     *        (string) $value header value
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function withAddedHeader($name, $value)
    {
        $this->setHeader($name, $value);

        return $this;
    }

    /**
     * Return an instance without the specified header.
     *
     * @param (string) $name header field/key name
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function withoutHeader($name)
    {
        $this->remove($name);

        return $this;
    }

    /**
     * Gets the body of the message.
     *
     * @since 3.0.0
     *
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Return an instance with the specified message body.
     *
     * @param (mixed) $body Body
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }
}