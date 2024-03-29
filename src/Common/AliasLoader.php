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

namespace alphaz\Common;

class AliasLoader
{
    /**
     * Class aliases.
     *
     * @since 1.0.0
     *
     * @var array
     */
    protected $aliases;

    /**
     * __construct.
     *
     * @param (array) $aliases Class aliases
     *
     * @since 1.0.0
     */
    public function __construct($aliases)
    {
        $this->aliases = $aliases;
    }

    /**
     * Autoloads aliased classes.
     *
     * @param (string) $alias Class alias
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function load($alias)
    {
        if (array_key_exists($alias, $this->aliases)) {
            return class_alias($this->aliases[$alias], $alias);
        }

        return false;
    }
}
