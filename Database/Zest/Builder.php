<?php

namespace Softhub99\Zest_Framework\Database\Zest;

use Softhub99\Zest_Framework\Database\Query\Query as QueryBuilder;

class Builder
{
    private static $table;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    public static function table(string $table)
    {
        if (!empty($table)) {
            self::$table = $table;

            return new static();
        }

        return false;
    }

    public function all()
    {
        $this->queryBuilder->select(self::$table);

        return $this;
    }

    public function select(array $fields)
    {
        $this->queryBuilder->select(self::$table, $fields);

        return $this;
    }

    public function create(array $params)
    {
        $this->queryBuilder->create(self::$table, $params);

        return $this;
    }

    public function orderBy(string $column, string $order)
    {
        $this->queryBuilder->select(self::$table)->orderBy($column, $order);

        return $this;
    }

    public function find($id, $column = 'id')
    {
        return $this->queryBuilder->find(self::$table, $column);
    }

    public function delete(int $id)
    {
        $this->queryBuilder->delete(self::$table, $id);

        return $this;
    }

    public function count(array $params)
    {
        $this->queryBuilder->count(self::$table, $params);

        return $this;
    }
}
