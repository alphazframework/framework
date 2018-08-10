<?php 
namespace Softhub99\Zest_Framework\Validation;
use Softhub99\Zest_Framework\Database\Db as DB;
use Config\Config;
class databaseRules extends StickyRules
{
	protected static $db_name = Config::DB_NAME;

	public function unique($column,$value,$table)
	{
		$db = new DB;
		$result = $db->db()->count(['db_name'=>static::$db_name,'table'=>$table,'wheres' => [$column.' ='."'{$value}'"]]);
		$db->db()->close();
		if($result === 0) {	
			return true;
		} else {
			return false;
		}
	}
}
