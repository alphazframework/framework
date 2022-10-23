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

class Argon2IdHashing extends ArgonHashing
{
    /**
     * Get the algroithm.
     *
     * @since 1.0.0
     *
     * @return \Constant
     */
    protected function algorithm()
    {
        return \PASSWORD_ARGON2ID;
    }

    /**
     * Get the algroithm keys.
     *
     * @since 1.0.0
     *
     * @return string
     */
    protected function algorithmKeys()
    {
        return 'argon2id';
    }
}
