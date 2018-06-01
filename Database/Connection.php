<?php

namespace Softhub99\Zest_Framework\Database;

use Config\Config;

class Connection
{
    private static $instance;

    /**
     * __Construct set the database values.
     *
     * @return void
     */
    private function __construct()
    {
        $this->driver = Config::DB_DRIVER;
        $this->host = Config::DB_HOST;
        $this->user = Config::DB_USER;
        $this->pass = Config::DB_PASS;
        $this->name = Config::DB_NAME;
    }

    /**
     * Get singleton instance.
     *
     * @return Connection
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get database connection.
     *
     * @return PDO
     */
    public function getConnection()
    {
        try {
            if ($this->driver === 'MySQL') {
                $connection = new \Softhub99\Zest_Framework\Database\MySQLConnection();
            } else {
                throw new \Exception("Driver {$this->driver} is not supportd!");
            }
            return $connection
                       ->setHost($this->host)
                       ->setUser($this->user)
                       ->setPass($this->pass)
                       ->setName($this->name)
                       ->getConnection();
        } catch (\Exception $e) {
            die('Error: '.$e->getMessage());
        }
    }
}
