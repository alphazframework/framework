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

namespace Zest\Container;

abstract class ServiceProvider
{
	/**
	 * Container.
	 *
	 * @since 3.0.0
	 *
	 * @var \zest\Container\Container
	 */
	protected $container;

	/**
	 * Config.
	 *
	 * @since 3.0.0
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * __construct.
	 *
	 * @param \zest\Container\Container $container Container.
	 * @param array                     $config Config.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	public function __construct(Container $container, array $config)
	{
		$this->container = $container;

		$this->config = $config;
	}

	/**
	 * Registers the service.
	 *
	 * @since 3.0.0
	 *
	 */
	abstract public function register();
}
