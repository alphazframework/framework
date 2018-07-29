<?php 
namespace Softhub99\Zest_Framework\Validation;
use Softhub99\Zest_Framework\Database\MYSQL as DB;
use Config\Config;
class databaseRules extends StickyRules
{
	protected static $db_name = Config::DB_NAME;

	public function unique($column,$value,$table)
	{
		$db = new DB;
		$result = $db->count(['db_name'=>static::$db_name,'table'=>$table,'wheres' => [$column.' ='."'{$value}'"]]);
		$db->close();
		if($result === 0) {	
			return true;
		} else {
			return false;
		}
	}
}