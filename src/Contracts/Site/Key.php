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

namespace alphaz\Contracts\Site;

interface Key
{
    /**
     * Converts a binary key into its hexadecimal representation.
     *
     * @param string $key Binary key
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function encode(string $key): string;

    /**
     * Converts a hexadecimal key into its binary representation.
     *
     * @param string $key Binary key
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function decode(string $key): string;

    /**
     * Generates a key.
     *
     * @param int $length Key length
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function generate(int $length = 32): string;

    /**
     * Generates a hex encoded key.
     *
     * @param int $length Key length
     *
     * @since 1.0.0
     *
     * @return string
     */
    public static function generateEncode(int $length = 32): string;
}
