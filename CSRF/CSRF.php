<?php 
namespace Softhub99\Zest_Framework\CSRF;
use Softhub99\Zest_Framework\Session\Session;
class CSRF{
	//default time
	private static $time;
	//System time
	private static $sysTime;
		/**
		 * __construct
		 *
		 *
		 * @return Void;
		 */
	public function __construct(){
			//delete expires tokens
			static::deleteExpires();
			//update system time
			static::updateSysTime();
			//session handler
			static::generateSession();


	}
		/**
		 * Delete token with $keye
		 *
		 * @key = $key token tobe deleted
		 *
		 * @return void;
		 */	
	public static function deleteToken($token){
		if(isset($_SESSION['security']['csrf'][$token])){
			unset($_SESSION['security']['csrf'][$token]);
		}
	}
		/**
		 * Delete expire tokens
		 *
		 *
		 * @return void;
		 */	
	public static function deleteExpires(){
		if(isset(Session::getValue('csrf'))){
			foreach (Session::getValue('csrf') as $token => $value) {
				if(time() >= $value ){
					unset(Session::getValue('csrf')[$token]);
				}
			}
		}
	}
		/**
		 * Delete unnecessary tokens
		 *
		 *
		 * @return void;
		 */	
	public static function deleteUnnecessaryTokens(){
		$total = static::countsTokens();
		$delete  = $total - 1;
		$tokens_deleted = Session::getValue('csrf')
		$tokens = array_slice($tokens_deleted, 0, $delete);
		foreach ($tokens as $token => $time) {
			static::deleteToken($token);
		}
	}
		/**
		 * Debug
		 *	return all tokens
		 *
		 * @return json object;
		 */	
  	public static function debug() {
    	echo json_encode(Session::getValue('csrf'), JSON_PRETTY_PRINT);

  	}	
		/**
		 * Update time
		 *
		 * @time = $time tobe updated
		 *
		 * @return bolean;
		 */
	public static function updateTime($time){
  		  if (is_int($time) && is_numeric($time)) { static::$time = $time;
     			 return static::$time;
	    }else{
	    	return false;
	    }	
   }
		/**
		 * Update system time
		 *
		 * @return void;
		 */
	 final private function updateSysTime(){
			static::$sysTime = time();
   }   
		/**
		* generate salts for files
		*
		* @param string $length length of salts
		 *
		 * @return string;
		 */	
	public function generateSalts( $length ){
		return \Zest_Framework\Site\Site::salts($length);		
	}   
		/**
		 * Generate tokens
		 *
		 *@param 
		 *$time => $time
		 *$multiplier => 3*3600
		 * @return mix-data;
		 */	
	public function generateTokens($time,$multiplier) {
			$key = static::generateSalts(100);
			$utime = static::updateTime($time);
			$value = static::$sysTime + ( $utime * $multiplier );
			$_SESSION['csrf'][$key] = $value;
			return $key;
	}
		/**
		 * Generate empty session
		 *
		 * @return void;
		 */		
	public function generateSession(){
		if (Session::isSession('csrf')!== true) {
			Session::setValue('csrf',[])
    	}
	}
		/**
		 * View token
		 *
		 * @token = $key
		 *
		 * @return mix-data;
		 */		
 	 public function view($token) {
    	if(isset($_SESSION['csrf'][$token])){
    		return $_SESSION['csrf'][$token];
   		 }else{
    		return false;
		}
	 }
		/**
		 * Verify token exists or not
		 *
		 * @token = $key
		 *
		 * @return boolean;
		 */		
 	 public function verify($token) {
    	if(isset($_SESSION['csrf'][$token])){
    		return true;
   		 }else{
    		return false;
		}
	 }	 
		/**
		 * Last token
		 *
		 * @return mix-data;
		 */
  	public function lastToken(){
  		if (Session::isSession('csrf')!== true) {
  			return end(Session::getValue('csrf'));
  		}else{
  			return false;
  		} 
  	}
		/**
		 * Count tokens
		 *
		 * @return int;
		 */  	
  	public function countsTokens(){
  		if (Session::isSession('csrf')!== true) {
  			return count(Session::getValue('csrf'));
  		}else{
  			return 0;
  		}
  	}
}