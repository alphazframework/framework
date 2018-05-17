<?php

namespace Softhub99\Zest_Framework\Model;
use \Config\Config;
use Softhub99\Zest_Framework\Database\Mysql;
use Softhub99\Zest_Framework\Files\Files;

class Model
{

    /**
     * __constructor.
     *
     */
    public function __construct(){}

    /**
     * Prevent unserializing.
     */
    private function __wakeup(){}

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    protected static function Db()
    {
        static $db = null;
        if ($db === null) {
             $db = new Mysql(Config::DB_HOST,Config::DB_USER, Config::DB_PASSWORD);
        }
        return $db;
    }
    protected function FIles(){
        return new Files;
    }

}
