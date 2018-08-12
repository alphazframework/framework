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
 * @license MIT
 */

namespace Zest\Cache\Memcache;

if (class_exists('Memcache')) {
    class Memcache
    {
        //Store the connectino of memcache
        private $conn;

        /**
         * __construct.
         */
        public function __construct($server, $port)
        {
            $this->conn = $this->connect($server, $port);
        }

        /**
         * Open connection.
         *
         * @param string $server , int port
         *
         * @return bool
         */
        public function connect($server, $port)
        {
            $mcache = new self();

            return $mcache->connect($server, $port);
        }

        /**
         * Close the connection.
         */
        public function close()
        {
            return $this->conn->close();
        }

        /**
         * Add the new server.
         *
         * @param striing $server , int $port
         *
         * @return bool
         */
        public function addServer($server, $port)
        {
            $this->conn->addServer($server, $port);
        }

        /**
         * Store the data.
         *
         * @param string $key , mix-data $data , timespamp $expire
         *
         * @return mix-data
         */
        public function store($key, $data, $exprie)
        {
            if ($exprie >= 2592000) {
                return 'exipre much be within 30days or passed 0 so this will never expire';
            }
            if ($this->conn->add($key, $data, MEMCACHE_COMPRESSED, $expire)) {
                return $data == $this->conn->get($key);
            } else {
                return false;
            }
        }

        /**
         * Update the data.
         *
         * @param string $key , mix-data $data , timespamp $expire
         *
         * @return mix-data
         */
        public function update($key, $data, $exprie)
        {
            if ($exprie >= 2592000) {
                return 'exipre much be within 30days or passed 0 so this will never expire';
            }
            if ($this->conn->set($key, $data, MEMCACHE_COMPRESSED, $expire)) {
                return $this->conn->get($key);
            } else {
                return false;
            }
        }

        /**
         * Replace the data.
         *
         * @param string $key , mix-data $data , timespamp $expire
         *
         * @return mix-data
         */
        public function replace($key, $data, $exprie)
        {
            if ($exprie >= 2592000) {
                return 'exipre much be within 30days or passed 0 so this will never expire';
            }
            if ($this->conn->replace($key, $data, MEMCACHE_COMPRESSED, $expire)) {
                return $this->conn->get($key);
            } else {
                return false;
            }
        }

        /**
         * get the data.
         *
         * @param string $key
         *
         * @return mix-data
         */
        public function get($key)
        {
            if (isset($key) && !empty($key)) {
                return $this->conn->get($key);
            }
        }

        /**
         * get the data on multiple keys.
         *
         * @param array $key
         *
         * @return array
         */
        public function getMultiple($key)
        {
            if (isset($key) && !empty($key)) {
                return $this->conn->get($key);
            }
        }

        /**
         * Delete the data.
         *
         * @param string $key
         *
         * @return bool
         */
        public function delete($key)
        {
            if (isset($key) && !empty($key)) {
                return $this->conn->delete($key);
            }
        }

        /**
         * Delete all data.
         *
         * @return bool
         */
        public function deleteMaster()
        {
            return $this->conn->flush();
        }

        /**
         * return version of memcache.
         *
         * @return int
         */
        public function version()
        {
            return $this->conn->getVersion();
        }
    }
} else {
    class mcache
    {
        /**
         * __construct.
         */
        public function __construct()
        {
            echo 'Sorry, class Memcache not found please install php Memcache extension';
        }
    }
}
