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

namespace Zest\Hashing;

class ArgonHashing extends AbstractHashing
{
    /**
     * The default memory cost.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $memory = 1024;

    /**
     * The default time cost.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $time = 2;

    /**
     * The default threads cost.
     *
     * @since 3.0.0
     *
     * @var int
     */
    private $threads = 2;

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
        $this->setMemory($options['memory'])->setTime($options['time'])->setThreads($options['threads']);

        $this->verifyAlgorithm = (isset($options['verify'])) ? $options['verify'] : false;
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
        if ($this->verifyAlgorithm && $this->info($hash)['algoName'] !== $this->algorithmKeys()) {
            throw new \Exception('This hash does not use '.$this->algorithmKeys().' algorithm', 500);
        }

        return parent::verify($original, $hash);
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
        if (is_array($options)) {
            $this->setMemory($options['memory'])->setTime($options['time'])->setThreads($options['threads']);
        }

        $hash = password_hash($original, $this->algorithm(), [
            'memory_cost' => $this->getMemory(),
            'time_cost'   => $this->getTime(),
            'threads'     => $this->getThreads(),
        ]);

        if (empty($hash)) {
            throw new \Exception($this->algorithmKeys().' hashing not supported.', 500);
        }

        return $hash;
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
        if (is_array($options)) {
            $this->setMemory($options['memory'])->setTime($options['time'])->setThreads($options['threads']);
        }

        return password_needs_rehash($hash, $this->algorithm(), [
            'memory_cost' => $this->getMemory(),
            'time_cost'   => $this->getTime(),
            'threads'     => $this->getThreads(),
        ]);
    }

    /**
     * Set the memory.
     *
     * @param (int) $memory
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setMemory($memory)
    {
        $this->memory = $memory ?? $this->memory;

        return $this;
    }

    /**
     * Set the time.
     *
     * @param (int) $time
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setTime($time)
    {
        $this->time = $time ?? $this->time;

        return $this;
    }

    /**
     * Set the threads.
     *
     * @param (int) $threads
     *
     * @since 3.0.0
     *
     * @return object
     */
    public function setThreads($threads)
    {
        $this->threads = $threads ?? $this->threads;

        return $this;
    }

    /**
     * Get the memory.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Get the time.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Get the threads.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getThreads()
    {
        return $this->threads;
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
        $algo = __config()->hashing->driver;

        switch (strtolower($algo)) {
            case 'argon2i':
                $algorithm = \PASSWORD_ARGON2I;
                break;
            case 'argon2id':
                $algorithm = \PASSWORD_ARGON2ID;
            default:
                $algorithm = \PASSWORD_ARGON2ID;
                break;
        }

        return $algorithm;
    }

    /**
     * Get the algroithm keys.
     *
     * @since 3.0.0
     *
     * @return string
     */
    protected function algorithmKeys()
    {
        $algo = __config()->hashing->driver;

        switch (strtolower($algo)) {
            case 'argon2i':
                $algorithm = 'argon2i';
                break;
            case 'argon2id':
                $algorithm = 'argon2id';
            default:
                $algorithm = 'argon2id';
                break;
        }

        return $algorithm;
    }
}
