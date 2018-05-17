<?php

namespace Core;
use PDO;
use App\Config;
use Softhub99\Zest_Framework\Database\Mysql;
use Softhub99\Zest_Framework\Files\Files

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
             $db = new Mysql(Config::DB_HOST,onfig::DB_USER, Config::DB_PASSWORD);
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }
    protected function FIles(){
        return new Files;
    }

}
