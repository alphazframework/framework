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
			static::DeleteExpires();
			//update system time
			static::UpdateSysTime();
			//session handler
			static::GenerateSession();


	}
		/**
		 * Delete token with $keye
		 *
		 * @key = $key token tobe deleted
		 *
		 * @return void;
		 */	
	public static function Delete($token){
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
	public static function DeleteExpires(){
		if(isset(Session::GetValue('csrf'))){
			foreach (Session::GetValue('csrf') as $token => $value) {
				if(time() >= $value ){
					unset(Session::GetValue('csrf')[$token]);
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
	public static function DeleteUnnecessaryTokens(){
		$total = static::CountsTokens();
		$delete  = $total - 1;
		$tokens_deleted = Session::GetValue('csrf')
		$tokens = array_slice($tokens_deleted, 0, $delete);
		foreach ($tokens as $token => $time) {
			static::Delete($token);
		}
	}
		/**
		 * Debug
		 *	return all tokens
		 *
		 * @return json object;
		 */	
  	public static function Debug() {
    	echo json_encode(Session::GetValue('csrf'), JSON_PRETTY_PRINT);

  	}	
		/**
		 * Update time
		 *
		 * @time = $time tobe updated
		 *
		 * @return bolean;
		 */
	public static function UpdateTime($time){
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
	 final private function UpdateSysTime(){
			static::$sysTime = time();
   }   
		/**
		* generate salts for files
		*
		* @param string $length length of salts
		 *
		 * @return string;
		 */	
	public function GenerateSalts( $length ){
		return \Zest_Framework\Site\Site::Salts($length);		
	}   
		/**
		 * Generate tokens
		 *
		 *@param 
		 *$time => $time
		 *$multiplier => 3*3600
		 * @return mix-data;
		 */	
	public function GenerateTokens($time,$multiplier) {
			$key = static::GenerateSalts(100);
			$utime = static::UpdateTime($time);
			$value = static::$sysTime + ( $utime * $multiplier );
			$_SESSION['csrf'][$key] = $value;
			return $key;
	}
		/**
		 * Generate empty session
		 *
		 * @return void;
		 */		
	public function GenerateSession(){
		if (Session::CheckStatus('csrf')!== true) {
			Session::SetValue('csrf',[])
    	}
	}
		/**
		 * View token
		 *
		 * @token = $key
		 *
		 * @return mix-data;
		 */		
 	 public function View($token) {
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
 	 public function Verify($token) {
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
  	public function LastToken(){
  		if (Session::CheckStatus('csrf')!== true) {
  			return end(Session::GetValue('csrf'));
  		}else{
  			return false;
  		} 
  	}
		/**
		 * Count tokens
		 *
		 * @return int;
		 */  	
  	public function CountsTokens(){
  		if (Session::CheckStatus('csrf')!== true) {
  			return count(Session::GetValue('csrf'));
  		}else{
  			return 0;
  		}
  	}
}