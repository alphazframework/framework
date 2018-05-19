<?php 

namespace Softhub99\Zest_Framework\Database;

class MySQLConnection implements ConnectionInterface
{
	private $host, $user, $pass, $name;

	/**
	 * Set database hostname for connection
	 *
	 * @param string $host
	 * @return MySQLConnection
	 */
	public function setHost(string $host)
	{
		$this->host = $host;

		return $this;
	}

	/**
	 * Set database username for connection
	 *
	 * @param string $user
	 * @return MySQLConnection
	 */
	public function setUser(string $user)
	{
		$this->user = $user;

		return $this;
	}

	/**
	 * Set database password for connection
	 *
	 * @param string $pass
	 * @return MySQLConnection
	 */
	public function setPass(string $pass)
	{
		$this->pass = $pass;

		return $this;
	}

	/**
	 * Set database name for connection
	 *
	 * @param string $user
	 * @return MySQLConnection
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get MySQL Connection
	 *
	 * @return PDO
	 */	
	public function getConnection()
	{
		try
		{
			return new \PDO("mysql:host={$this->host};dbname={$this->name}", $this->user, $this->pass);
		}
		catch(\PDOException $e)
		{
			die("PDOException: ".$e->getMessage());
		}
	}
}
