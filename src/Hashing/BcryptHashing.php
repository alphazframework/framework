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

class BcryptHashing extends AbstractHashing
{
    /**
     * The default cost.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $cost = 10;

    /**
     * Determine whether to perform an algorithm check.
     *
     * @since 3.0.0
     *
     * @var bool
     */
    private $verifyAlgorithm = false;

    /**
     * __construct.
     *
     * @param (array) $options
     *
     * @since 3.0.0
     */
    public function __construct(array $options)
    {
        $this->setCost($options['cost']);

        $this->verifyAlgorithm = $options['verify'];
    }

    /**
     * Verify the hash value.
     *
     * @param (string) $original
     * @param (string) $hash
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function verify($original, $hash)
    {
        if ($this->verifyAlgorithm && $this->info($hash)['algoName'] !== 'bcrypt') {
            throw new \Exception('This hash does not use bcrypt algorithm', 500);
        }

        return parent::verify($original, $hash);
    }

    /**
     * Generate the hash.
     *
     * @param (string) $original
     * @param (array) optional $options
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function make($original, $options = null)
    {
        if (is_array($options)) {
            $this->setCost($options['cost']);
        }

        $hash = password_hash($original, $this->algorithm(), [
            'cost' => $this->getCost(),
        ]);

        if (empty($hash)) {
            throw new \Exception('Bcrypt hashing not supported.', 500);
        }

        return $hash;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param (string)         $original
     * @param (array) optional $options
     *
     * @since 3.0.0
     *
     * @return bool
     */
    public function needsRehash($hash, $options = null)
    {
        if (is_array($options)) {
            $this->setCost($options['cost']);
        }

        return password_needs_rehash($hash, $this->algorithm(), [
            'cost' => $this->getCost(),
        ]);
    }

    /**
     * Set the cost.
     *
     * @param (int) $cost
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setCost($cost)
    {
        $this->cost = $cost ?? $this->cost;

        return $this;
    }

    /**
     * Get the cost value.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Get the algroithm.
     *
     * @since 3.0.0
     *
     * @return \Constant
     */
    protected function algorithm()
    {
        return \PASSWORD_BCRYPT;
    }
}
