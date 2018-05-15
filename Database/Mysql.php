<?php
	/**
	 * PHP MYSQL Manipulation Class
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link     https://github.com/Lablnet/PHP-MYSQL-Manipulation-Class
	 *
	 */
	/**
	 * PHP class
	 * Database name should be provided once needed
	 * @param db-host,db-user,db-pass
	 */	 
namespace Softhub99\Zest_Framework\MYSQL;

class MYSQL
{

		/**
		 * For sotring database settings 
		 * @access private
		 */	 	
	private $settings;	
		/**
		 * For sotring database connection reference
		 * @access private
		 */	 	
	private $db;

		/**
		 * Set the values
		 *
		 * @return void
		 */	 
	public function __construct($host,$user,$pass){

		$this->DbSettings($host,$user,$pass);

		$this->db = self::Connect(true);

	}		
		/**
		 * Open database connection
		 *
		 * @param $status true : false  true means open false colse
		 *
		 * @access private 
		 * @return boolean
		 */	 
	private function Connect($status){

	    if($status === true){

	    	$setting = $this->settings;
	        

	        return $db = new PDO('mysql:host='.$setting['host'], $setting['user'], $setting['pass']);
	    }

	    if($status === false){

	        return $db = null;

	    }

	 }
		/**
		 * Close database connection
		 *
		 * @return void
		 */	 
	 public function Close(){

		self::Connect(false);

		unset($this->db);

		unset($this->settings);

	 }

		/**
		 * Database default setting
		 *
		 * @param 
		 * $host Database host
		 * $user Database user
		 * $pass Database pass 
		 *
		 * @access private
		 * @return void
		 */	 	 
	private function DbSettings($host,$user,$pass){

		$this->settings =  [
			'host' => $host,
			'user' => $user,
			'pass' => $pass,
		];

		return;

	} 

		/**
		 * Prepare a query to insert into db
		 *
		 * @param 
		 * $table Name of tabke 
		 * array array(); e.g:
		 *           'name' => 'new name' or $comeformvariable
		 *           'username' => 'new username' or $comeformvariable
		 *
		 * @return integar or boolean
		 */	 	 
	 public function Insert($table,$db,$param){

		$columns = implode(',',array_keys($param));

		$values = ':'.implode(', :',array_keys($param));

		$sql = "INSERT INTO {$table} ({$columns}) values ({$values})";

		$this->db->exec("USE `{$db}`");

		if($stmt = $this->db->prepare($sql)){

			foreach($param as $key => $data){

				$stmt->bindValue(':'.$key,$data);

			}
				
			$stmt->execute();

			$last =  $this->db->lastInsertId();

			$stmt->closeCursor();

			return $last;

		}

		return false;

	}
		/**
		 * Prepare a query to Update data in database
		 * @param array $params; e.g:
		 * 'table' required name of table
		 * 'db_name' => Database name
		 * 'wheres' Specify id or else for updating records
		 * 'columns' => data e.g name=>new name
		 *
		 * @return boolean
		 */	 
	public function Update($params){

		if(is_array($params)){

				$count_rows = count($params['columns']);

				$increment      = 1;

			foreach($params['columns'] as $keys => $value) {

				for($i=1;$i<=$count_rows;$i++){

						$data[$keys] = $value;

					}

			}

			foreach($data as $keys => $values) {

				if($increment == $count_rows) {

						$columns [] = "{$keys} = '{$values}'";

				} else {

						$columns [] = "{$keys} = '{$values}'";

				}

				$increment++;

			}

			$columns  = implode(' , ', $columns);

			if(isset($params['wheres'])) {		

				if(!empty($params['wheres'])) {

						$wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

				}else{

					$wheres = '';

				}
			}else{

				$wheres = '';

			}			
				$query  = "UPDATE `{$params['table']}`SET {$columns} {$wheres}";

					if(isset($params['debug']) and strtolower($params['debug']) === 'on' ){

					    	var_dump($query);

					}

					$this->db->exec("USE `{$params['db_name']}`");

					$prepare = $this->db->prepare($query);

					if($prepare->execute()) {

						$prepare->closeCursor();

						return true;

					}			

		}else{

			return false;

		}		

	}
		/**
		 * quote the string
		 *
		 * @param $string  
		 *
		 * @return string
		 */	 
	public function Quote($string){

		$quote = $this->db->quote($string);

		return $quote;

	}		
		/**
		 * Prepare a query to select data from database
		 *
		 * @param array array();
		 *           'table' Names of table
		 * 			 'db_name' => Database name	
		 *           'params' Names of columns which you want to select
		 *           'wheres' Specify a selection criteria to get required records
		 *            'debug' If on var_dump sql query
		 * @return boolean
		 */	 
	public function Select($params) {

		if(is_array($params)) {	

					if(!isset($params['params'])) {

							$columns = '*';

					} else {

					    $columns = implode(', ',array_values($params['params']));

					}				

					$wheres = '';

					if(!empty($params['wheres'])) {

					    $wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

					}
					
					if(isset($params['joins'])){

						if(!empty($params['joins']))
							if(!isset($params['joins']['using'])){

							$join = " JOIN ".$params['joins']['table2'].' ON '.$params['joins']['column1'] .' = ' . $params['joins']['column2'];

						}else{

							$join = " JOIN ".$params['joins']['table2'].' Using '.$params['joins']['using'];

						}	
						
					}else{

						$join = '';

					}
					if(isset($params['limit'])){

						if(!empty($params['limit'])){
							$limit = " LIMIT ".$params['limit']['start']." OFFSET ".$params['limit']['end'];

						}else{

							$limit = '';

						}
					}else{	

						$limit = '';

					}
					if(isset($params['order_by'])){

						if(!empty($params['order_by'])){

							$order_by = " ORDER BY ". $params['order_by'];

						}else{

							$order_by = '';

						}
					}else{

						$order_by = '';

					}

					$query = "SELECT {$columns} FROM {$params['table']} {$join} {$wheres} {$order_by} {$limit} ;";

					if(isset($params['debug']) and strtolower($params['debug']) === 'on' ){

					    var_dump($query);

					}

					$this->db->exec("USE `{$params['db_name']}`");	
					$prepare =  $this->db->prepare($query);

					if($prepare->execute()) {

							$data = $prepare->fetchAll(PDO::FETCH_ASSOC);

							$prepare->closeCursor();

							return $data;

					}
			}

			return false;

	}
	/**
	 * Prepare a query to delete data from database
	 *
	 * @param $params array array();
	 *           'table' Names of table
	 *			 'db_name' => Database name		
	 *           'wheres' Specify a selection criteria to get required records
	 *
	 * @return boolean
	 */	
	public function Delete($params) {

			if(is_array($params)) {

					if(!empty($params['wheres'])) {

							$wheres = "WHERE " . implode(' and ', array_values($params['wheres']));

					}else{

							return false;

					}
					$query = "DELETE FROM `{$params['table']}` {$wheres};";

					$this->db->exec("USE `{$params['db_name']}`");

					$prepare =  $this->db->prepare($query);

					if($prepare->execute()) {

							$prepare->closeCursor();

							return true;
					}

			}

			return false;

	}
		/**
		 * Prepare a query to count data from database
		 *
		 * @param $params array();
		 *           'table' Names of table
		 *			 'db_name' => Database name	
		 *           'columns' Names of columnswant to select
		 *           'wheres' Specify a selection 		 *       
		 * @return boolean
		 */	 	
	public function Count($params){
		
		if(is_array($params)){

			$table = $params['table'];

			if(isset($params['columns'])){

				$columns = implode(',',array_values($params['columns']));

			}else{

				$columns = '*';

			}

			if(!empty($params['wheres'])){

		    	$where = "WHERE " . implode(' and ', array_values($params['wheres']));

				$sql = "SELECT {$columns} FROM {$table} {$where}";
				
				$this->db->exec("USE `{$params['db_name']}`");

				$prepare =  $this->db->prepare($sql);

				$prepare->execute();

				$count = $prepare->rowCount();

				$prepare->closeCursor();

				return $count;

			}else{

				return false;

			}
		}else{

			return false;

		}

	}

		/**
		 * Creating database if not exists
		 *
		 * @param $name name of database
		 *
		 * @return boolean
		 */	
	public function CreateDb($name){

		if(isset($name) && !empty(trim($name))){

			$sql = "CREATE DATABASE IF NOT EXISTS `{$name}`";

			$this->db->exec($sql);

			return true;

			
		}else{

			return false;

		}

	}

		/**
		 * Deleting database if not exists
		 *
		 * @param $name name of database
		 *
		 * @return boolean
		 */		
	public function DeleteDb($name){

		if(isset($name) && !empty(trim($name))){

			$sql = "DROP DATABASE `{$name}` ";

			$this->db->exec($sql);	

			return true;

			
		}else{

			return false;

		}

	}

		/**
		 * Deleting table if not exists
		 *
		 * @param $dbname name of database
		 * $table => $table name
		 *
		 * @return boolean
		 */	
	public function DeleteTbl($dbname,$table){

		if(isset($dbname) && !empty(trim($dbname)) && isset($table) && !empty(trim($table))){

			$this->db->exec("USE `{$dbname}` ");	

			$sql = "DROP TABLE `{$table}` ";

			$this->db->exec($sql);

			return true;

			
		}else{

			return false;

		}

	}	

		/**
		 * Creating table
		 *
		 * @param $dbname name of database
		 * $sql => for creating tables
		 *
		 * @return boolean
		 */	
	public function CreateTbl($dbname,$sql){

		if(isset($dbname) && !empty(trim($dbname)) && isset($sql) && !empty(trim($sql))){

			$this->db->exec("USE `{$dbname}` ");	

			$this->db->exec($sql);		

			return true;
	
		}else{

			return false;

		}

	}
}