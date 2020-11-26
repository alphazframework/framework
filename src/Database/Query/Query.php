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

namespace Zest\Database\Query;

class Query
{
    /**
     * Prepare a query to insert into db.
     *
     * @param
     * $table Name of tabke
     * array array(); e.g:
     *           'name' => 'new name' or $comeformvariable
     *           'username' => 'new username' or $comeformvariable
     *
     * @return query
     */
    public function insert($params)
    {
        if (is_array($params)) {
            $count_rows = count($params['columns']);
            $increment = 1;
            foreach ($params['columns'] as $keys => $value) {
                for ($i = 1; $i <= $count_rows; $i++) {
                    $data[$keys] = $value;
                }
            }
            foreach ($data as $keys => $values) {
                if ($increment == $count_rows) {
                    $columns[] = "{$keys} = '{$values}'";
                } else {
                    $columns[] = "{$keys} = '{$values}'";
                }
                $increment++;
            }
            $columns = implode(' , ', $columns);
            $query = "INSERT INTO `{$params['table']}`SET {$columns}";
            if (isset($params['debug']) and strtolower($params['debug']) === 'on') {
                var_dump($query);
            }

            return $query;
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
     * @return query
     */
    public function update($params)
    {
        if (is_array($params)) {
            $count_rows = count($params['columns']);
            $increment = 1;
            foreach ($params['columns'] as $keys => $value) {
                for ($i = 1; $i <= $count_rows; $i++) {
                    $data[$keys] = $value;
                }
            }
            foreach ($data as $keys => $values) {
                if ($increment == $count_rows) {
                    $columns[] = "{$keys} = '{$values}'";
                } else {
                    $columns[] = "{$keys} = '{$values}'";
                }
                $increment++;
            }
            $columns = implode(' , ', $columns);
            $wheres = $this->prepareWhere($params['wheres']);
            $query = "UPDATE `{$params['table']}`SET {$columns} {$wheres}";
            if (isset($params['debug']) and strtolower($params['debug']) === 'on') {
                var_dump($query);
            }

            return $query;
        } else {
            return false;
        }
    }

    /**
     * Prepare a query to select data from database.
     *
     * @param array array();
     *           'table' Names of table
     *           'db_name' => Database name
     *           'params' Names of columns which you want to select
     *           'wheres' Specify a selection criteria to get required records
     *            'debug' If on var_dump sql query
     *
     * @return query
     */
    public function select($params)
    {
        if (is_array($params)) {
            if (!isset($params['params'])) {
                $columns = '*';
            } else {
                $columns = implode(', ', array_values($params['params']));
            }
            if (isset($params['distinct'])) {
                $distinct = ' DISTINCT ';
            } else {
                $distinct = '';
            }
            $wheres = (isset($params['wheres'])) ? $this->prepareWhere($params['wheres']) : '';
            if (isset($params['joins'])) {
                if (!empty($params['joins'])) {
                    if (!isset($params['joins']['using'])) {
                        $join = ' JOIN '.$params['joins']['table2'].' ON '.$params['joins']['column1'].' = '.$params['joins']['column2'];
                    } else {
                        $join = ' JOIN '.$params['joins']['table2'].' Using '.$params['joins']['using'];
                    }
                }
            } else {
                $join = '';
            }
            if (isset($params['limit'])) {
                if (!empty($params['limit'])) {
                    $limit = ' LIMIT '.$params['limit']['start'].' OFFSET '.$params['limit']['end'];
                } else {
                    $limit = '';
                }
            } else {
                $limit = '';
            }
            if (isset($params['order_by'])) {
                if (!empty($params['order_by'])) {
                    $order_by = ' ORDER BY '.$params['order_by'];
                } else {
                    $order_by = '';
                }
            } else {
                $order_by = '';
            }
            $query = "SELECT {$distinct} {$columns} FROM {$params['table']} {$join} {$wheres} {$order_by} {$limit} ;";
            if (isset($params['debug']) and strtolower($params['debug']) === 'on') {
                var_dump($query);
            }

            return $query;
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
     * @return query
     */
    public function delete($params)
    {
        if (is_array($params)) {
            if (!empty($params['wheres'])) {
                $wheres = $this->prepareWhere($params['wheres']);
            } else {
                return false;
            }
            $query = "DELETE FROM `{$params['table']}` {$wheres};";
            if (isset($params['debug']) and strtolower($params['debug']) === 'on') {
                var_dump($query);
            }

            return $query;
        } else {
            return false;
        }
    }

    /**
     * prepare the where statement.
     *
     * @param 'wheres' Specify a selection criteria to get required records
     *
     * @return query
     */
    public function prepareWhere($wheres = null)
    {
        if (isset($wheres)) {
            if (!empty($wheres)) {
                $wheres = ' WHERE '.implode(' and ', array_values($wheres));
            } else {
                $wheres = '';
            }
        } else {
            $wheres = '';
        }

        return $wheres;
    }

    /**
     * Prepare the use statement.
     *
     * @param $name name of database
     *
     * @return query
     */
    public function useQuery($name)
    {
        return "USE `{$name}`";
    }

    /**
     * Creating database query if not exists.
     *
     * @param $name name of database
     *
     * @return query
     */
    public function createDb($name)
    {
        if (isset($name) && !empty(trim($name))) {
            $sql = "CREATE DATABASE IF NOT EXISTS `{$name}`";

            return $sql;
        } else {
            return false;
        }
    }

    /**
     * Deleting database query if not exists.
     *
     * @param $name name of database
     *
     * @return query
     */
    public function deleteDb($name)
    {
        if (isset($name) && !empty(trim($name))) {
            $sql = "DROP DATABASE `{$name}` ";

            return $sql;
        } else {
            return false;
        }
    }

    /**
     * Deleting table  query if not exists.
     *
     * @param $dbname name of database
     * $table => $table name
     *
     * @return query
     */
    public function deleteTbl($table)
    {
        if (isset($table) && !empty(trim($table))) {
            $sql = "DROP TABLE `{$table}` ";

            return $sql;
        } else {
            return false;
        }
    }
}
