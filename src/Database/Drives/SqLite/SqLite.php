<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author Muhammad Umer Farooq (Malik) <mumerfarooqlablnet01@gmail.com>
 *
 * @link https://github.com/zestframework/Zest_Framework
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Database\Drives\SqLite;

use Zest\Database\Query\Query;

/**
 * PHP class
 * Database name should be provided once needed.
 *
 * @param dbName
 */
class SqLite
{
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
            return $db = new \SQLite3(__config()->database->sqlite_name, SQLITE3_OPEN_READWRITE);
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
        $prepare = $this->db->exec($query);
        if ($prepare) {
            return true;
        }

        return false;
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
        $quote = addslashes($string);

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
        $prepare = $this->db->query($query);
        if ($prepare) {
            $data = $prepare->fetchArray();

            return $data;
        }

        return false;
    }

    /**
     * Prepare a query to delete data from database.
     *
     * @param $params array array();
     *           'table' Names of table
     *             'db_name' => Database name
     *           'wheres' Specify a selection criteria to get required records
     *
     * @return bool
     */
    public function delete($params)
    {
        $query = $this->query->delete($params);
        $prepare = $this->db->exec($query);
        if ($prepare) {
            return true;
        }

        return false;
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
     * Deleting database if not exists.
     *
     * @param $name name of database
     *
     * @return bool
     */
    public function deleteDb($name)
    {
        $file = __config()->database->sqlite_name;
        if (file_exists($file)) {
            unset($file);

            return true;
        }

        return false;
    }

    /**
     * Deleting table if not exists.
     *
     * @param $dbname name of database
     * $table => $table name
     *
     * @return bool
     */
    public function deleteTbl($table)
    {
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
    public function createTbl($sql)
    {
        if (isset($sql) && !empty(trim($sql))) {
            $this->db->exec($sql);

            return true;
        } else {
            return false;
        }
    }
}
