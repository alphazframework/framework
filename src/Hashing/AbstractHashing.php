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

namespace alphaz\Hashing;

abstract class AbstractHashing
{
    /**
     * Get information about the given hash.
     *
     * @param (string) $hash
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function info($hash)
    {
        return password_get_info($hash);
    }

    /**
     * Verify the hash value.
     *
     * @param (string) $original
     * @param (string) $hash
     *
     * @since 1.0.0
     *
     * @return bool
     */
    public function verify($original, $hash)
    {
        if (empty($hash)) {
            return false;
        }

        return password_verify($original, $hash);
    }
}
