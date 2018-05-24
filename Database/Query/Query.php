<?php 

namespace Softhub99\Zest_Framework\Database\Query;

use Softhub99\Zest_Framework\Database\Connection;

class Query
{

	/**
	 * __Construct set the database connection
	 *
	 * @return void
	 */	
	public function __construct()
	{
		$this->connection = Connection::getInstance()->getConnection();
	}

	/**
	 * Get all columns from table
	 *
	 * @return array
	 */	
	private function getColumns($table): array
	{
		$prepare = $this->connection->prepare("DESCRIBE {$table};");
		$prepare->execute();

		return $prepare->fetchAll(\PDO::FETCH_COLUMN);
	}

	/**
	 * Select all data from table
	 *
	 * @return array
	 */	
	public function all($table): array
	{
		$prepare = $this->connection->prepare("SELECT * FROM {$table};");

		if ($prepare->execute())
			return $prepare->fetchAll(\PDO::FETCH_OBJ);
	}

	/**
	 * Select data from table with columns
	 *
	 * @return array
	 */	
	public function select($table,array $columns)
	{
		try
		{
			foreach ($columns as $column)
			{
				if (in_array($column, $this->getColumns($table)))
				{
					$columns[] = $column;
				}
				else
				{
					throw new \Exception("Column <b>$column</b> is not supported!");
				}
			}
			$columns = implode(', ', $columns);

			$prepare = $this->connection->prepare("SELECT $columns FROM {$table};");

			if ($prepare->execute())
		 		return ($prepare->rowCount() == 1 ? $prepare->fetch(\PDO::FETCH_OBJ) : $prepare->fetchAll(\PDO::FETCH_OBJ));
		}
		catch (\Exception $e)
		{
			die("Error: ".$e->getMessage());
		}
	}

	/**
	 * Select data from table with id
	 * 
	 * @param int/string $id
	 * @return array
	 */	
	public function find($table,$id)
	{
		if (!is_array($id))
		{
			$prepare = $this->connection->prepare("SELECT * FROM {$table} WHERE {$this->getColumns($table)[0]} = ?;");

			if ($prepare->execute([$id]))
				return ($prepare->rowCount() == 1 ? $prepare->fetch(\PDO::FETCH_OBJ) : $prepare->fetchAll(\PDO::FETCH_OBJ));
		}
	}

	/**
	 * Select data from table with id
	 * 
	 * @param string $column, string $sort
	 * @return array
	 */	
	public function orderBy(string $column, string $sort): array
	{
		try
		{
			if (in_array($column, $this->getColumns()))
			{
				$prepare = $this->connection->prepare("SELECT * FROM {$this->table} ORDER BY $column $sort;");

				if ($prepare->execute())
					return $prepare->fetchAll(\PDO::FETCH_OBJ);
			}
			throw new \Exception("Column <b>$column</b> is not supported!");
		}
		catch (\Exception $e)
		{
			die("Error: ".$e->getMessage());
		}
	}

	/**
	 * Insert data to table
	 *
	 * @param  array $data
	 * @return boolean
	 */	
	public function create($table,array $data): bool
	{
		try
		{
			if (!count($data) < 1)
			{
				foreach ($data as $column => $value)
				{
					if (in_array($column, $this->getColumns($table)))
					{
						$columns[] = $column;
						$values[]  = $value;
					}
					else
					{
						var_dump($data);
						//throw new \Exception("Column <b>$column</b> is not supported!");
					}
				}
				$columns = implode(', ', $columns);
				$params  = str_repeat('?, ', count($data));
				$params  = substr($params, 0, -2);

				$query = "INSERT INTO {$table} ($columns) VALUES ($params);";
				$prepare = $this->connection->prepare($query);

				return ($prepare->execute($values) ? true : false);
			}
			return false;
		}
		catch (\Exception $e)
		{
			die("Error: ".$e->getMessage());
		}
	}

	/**
	 * Update data from table
	 *
	 * @param  array $data, int/string $id
	 * @return boolean
	 */	
	public function update($id, array $data): bool
	{
		try
		{
			if (!count($data) < 1 || !is_array($id) || !empty($id))
			{
				foreach ($data as $column => $value)
				{
					if (in_array($column, $this->getColumns()))
					{
						$columns[] = "$column = ?";
						$values[]  = $value;
					}
					else
					{
						throw new \Exception("Column <b>$column</b> is not supported!");
					}
				}
				$values[] = $id;
				$columns  = implode(', ', $columns);

				$query = "UPDATE {$this->table} SET $columns WHERE {$this->getColumns()[0]} = ?;";
				$prepare = $this->connection->prepare($query);

				return ($prepare->execute($values) ? true : false);
			}
			return false;
		}
		catch (\Exception $e)
		{
			die("Error: ".$e->getMessage());
		}
	}

	/**
	 * Delete data from table
	 *
	 * @param  int/string $id
	 * @return boolean
	 */	
	public function delete($table,$id)
	{
		try
		{
			if (!is_array($id) || !empty($id))
			{
				$query = "DELETE FROM {$table} WHERE {$this->getColumns($table)[0]} = ?;";
				$prepare = $this->connection->prepare($query);

				return ($prepare->execute([$id]) ? true : false);
			}
			return false;
		}
		catch(\Exception $e)
		{
			die("Error: ".$e->getMessage());
		}
	}
}
