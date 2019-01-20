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

namespace Zest\Hashing;

class Hashing
{
    /**
     * Store the instance of Hash driver.
     *
     * @since 3.0.0
     *
     * @var object
     */
    private $driver;

    /**
     * __construct.
     *
     * @since 3.0.0
     */
    public function __construct($verify = false)
    {
        $driver = __config()->hashing->driver;
        if ($driver === 'bcrypt') {
            $this->driver = new BcryptHashing(['cost' => __config()->hashing->bcrypt->cost]);
        } elseif ($driver === 'argon2id' || $driver === 'argon2i') {
            $this->driver = new ArgonHashing([
                'memory'  => __config()->hashing->argon->memory,
                'time'    => __config()->hashing->argon->time,
                'threads' => __config()->hashing->argon->threads,
                'verify'  => $verify,
            ]);
        } else {
            throw new \Exception('We\'re sorry, The hashing driver '.$driver.' not supported.', 500);
        }
    }

    /**
     * Generate the hash.
     *
     * @param (string)         $original
     * @param (array) optional $options
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function make($original, $options = null)
    {
        return $this->driver->make($original, $options);
    }

    /**
     * Verify the hash.
     *
     * @param (string) $original
     * @param (string) $hash
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function verify($original, $hash)
    {
        return $this->driver->verify($original, $hash);
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param (string)         $hash
     * @param (array) optional $options
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function needsRehash($hash, $options = null)
    {
        return $this->driver->needsRehash($hash, $options);
    }
}
