<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://lablnet.github.io/profile/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Database\Drives\MYSQL;

use Zest\Database\Query\Query;

/**
 * PHP class
 * Database name should be provided once needed.
 *
 * @param db-host,db-user,db-pass
 */
class MySqlDb
{
    /**
     * For sotring database settings.
     */
    private $settings;
    /**
     * For sotring database connection reference.
     */
    private $db;
    private $query;

    /**
     * Set the values.
     *
     * @return void
     */
    public function __construct()
    {
        $this->query = new Query();
        $this->db = self::connect(true);
    }

    /**
     * Open database connection.
     *
     * @param $status true : false  true means open false colse
     *
     * @return bool
     */
    private function connect($status)
    {
        if ($status === true) {
            $setting = $this->settings;

            return $db = new \PDO('mysql:host='.__config()->database->mysql_host, __config()->database->mysql_user, __config()->database->mysql_pass);
        }
        if ($status === false) {
            return $db = null;
        }
    }

    /**
     * Close database connection.
     *
     * @return void
     */
    public function close()
    {
        self::connect(false);

        unset($this->db);

        unset($this->settings);
    }

    /**
     * Database default setting.
     *
     * @param
     * $host Database host
     * $user Database user
     * $pass Database pass
     *
     * @return void
     */
    private function dbSettings($host, $user, $pass)
    {
        $this->settings = [
            'host' => $host,
            'user' => $user,
            'pass' => $pass,
        ];
    }

    /**
     * Prepare a query to insert into db.
     *
     * @param
     * $table Name of tabke
     * array array(); e.g:
     *           'name' => 'new name' or $comeformvariable
     *           'username' => 'new username' or $comeformvariable
     *
     * @return integar or boolean
     */
    public function insert($params)
    {
        $query = $this->query->insert($params);
        $this->db->exec($this->query->useQuery($params['db_name']));
        $prepare = $this->db->prepare($query);
        if ($prepare->execute()) {
            $last = $this->db->lastInsertId();
            $prepare->closeCursor();

            return $last;
        } else {
            return false;
        }
    }

    /**
     * Prepare a query to Update data in database.
     *
     * @param array $params; e.g:
     *                       'table' required name of table
     *                       'db_name' => Database name
     *                       'wheres' Specify id or else for updating records
     *                       'columns' => data e.g name=>new name
     *
     * @return bool
     */
    public function update($params)
    {
        $query = $this->query->update($params);
        $this->db->exec($this->query->useQuery($params['db_name']));
        $prepare = $this->db->prepare($query);
        if ($prepare->execute()) {
            $prepare->closeCursor();

            return true;
        } else {
            return false;
        }
    }

    /**
     * quote the string.
     *
     * @param $string
     *
     * @return string
     */
    public function quote($string)
    {
        $quote = $this->db->quote($string);

        return $quote;
    }

    /**
     * Prepare a query to select data from database.
     *
     * @param array array();
     *           'table' Names of table
     *              'db_name' => Database name
     *           'params' Names of columns which you want to select
     *           'wheres' Specify a selection criteria to get required records
     *            'debug' If on var_dump sql query
     *
     * @return bool
     */
    public function select($params)
    {
        $query = $this->query->select($params);
        $this->db->exec($this->query->useQuery($params['db_name']));
        $prepare = $this->db->prepare($query);
        if ($prepare->execute()) {
            $data = $prepare->fetchAll(\PDO::FETCH_ASSOC);
            $prepare->closeCursor();

            return $data;
        } else {
            return false;
        }
    }

    /**
     * Prepare a query to delete data from database.
     *
     * @param $params array array();
     *           'table' Names of table
     *           'db_name' => Database name
     *           'wheres' Specify a selection criteria to get required records
     *
     * @return bool
     */
    public function delete($params)
    {
        $query = $this->query->delete($params);
        $this->db->exec($this->query->useQuery($params['db_name']));
        $prepare = $this->db->prepare($query);
        if ($prepare->execute()) {
            $prepare->closeCursor();

            return true;
        }
    }

    /**
     * Prepare a query to count data from database.
     *
     * @param $params array();
     *           'table' Names of table
     *             'db_name' => Database name
     *           'columns' Names of columnswant to select
     *           'wheres' Specify a selection          *
     *
     * @return bool
     */
    public function count($params)
    {
        return count($this->select($params));
    }

    /**
     * Creating database if not exists.
     *
     * @param $name name of database
     *
     * @return bool
     */
    public function createDb($name)
    {
        $sql = $this->query->createDb($name);
        $this->db->exec($sql);

        return true;
    }

    /**
     * Deleting database if not exists.
     *
     * @param $name name of database
     *
     * @return bool
     */
    public function deleteDb($name)
    {
        $sql = $this->query->deleteDb($name);
        $this->db->exec($sql);

        return true;
    }

    /**
     * Deleting table if not exists.
     *
     * @param $dbname name of database
     * $table => $table name
     *
     * @return bool
     */
    public function deleteTbl($dbname, $table)
    {
        $this->db->exec($this->query->useQuery($dbname));
        $sql = $this->query->deleteTbl($table);
        $this->db->exec($sql);

        return true;
    }

    /**
     * Creating table.
     *
     * @param $dbname name of database
     * $sql => for creating tables
     *
     * @return bool
     */
    public function createTbl($dbname, $sql)
    {
        if (isset($dbname) && !empty(trim($dbname)) && isset($sql) && !empty(trim($sql))) {
            $this->db->exec("USE `{$dbname}` ");

            $this->db->exec($sql);

            return true;
        } else {
            return false;
        }
    }
}
