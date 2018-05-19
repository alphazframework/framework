<?php 

namespace Softhub99\Zest_Framework\Database;

interface ConnectionInterface
{
	public function setHost(string $host);
	public function setUser(string $user);
	public function setPass(string $pass);
	public function setName(string $name);

	public function getConnection();
}
