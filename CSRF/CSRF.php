<?php 
namespace Softhub99\Zest_Framework\CSRF;
class CSRF{
	//default time
	private $time;
	//System time
	private $sysTime;
		/**
		 * __construct
		 *
		 *
		 * @return Void;
		 */
	public function __construct(){
			//delete expires tokens
			self::DeleteExpires();
			//update system time
			self::UpdateSysTime();
			//session handler
			self::GenerateSession();


	}
		/**
		 * Delete token with $keye
		 *
		 * @key = $key token tobe deleted
		 *
		 * @return void;
		 */	
	public function Delete($token){
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
	public function DeleteExpires(){
		if(isset($_SESSION['security']['csrf'])){
			foreach ($_SESSION['security']['csrf'] as $token => $value) {
				if(time() >= $value ){
					unset($_SESSION['security']['csrf'][$token]);
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
	public function DeleteUnnecessaryTokens(){
		$total = self::CountsTokens();
		$delete  = $total - 1;
		$tokens_deleted = $_SESSION['security']['csrf'];
		$tokens = array_slice($tokens_deleted, 0, $delete);
		foreach ($tokens as $token => $time) {
			self::Delete($token);
		}
	}
		/**
		 * Debug
		 *	return all tokens
		 *
		 * @return json object;
		 */	
  	public function Debug() {
    	echo json_encode($_SESSION['security']['csrf'], JSON_PRETTY_PRINT);

  	}	
		/**
		 * Update time
		 *
		 * @time = $time tobe updated
		 *
		 * @return bolean;
		 */
	public function UpdateTime($time){
  		  if (is_int($time) && is_numeric($time)) { $this->time = $time;
     			 return $this->time;
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
			$this->sysTime = time();
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
			$key = self::GenerateSalts(100);
			$utime = self::UpdateTime($time);
			$value = $this->sysTime + ( $utime * $multiplier );
			$_SESSION['security']['csrf'][$key] = $value;
			return $key;
	}
		/**
		 * Generate empty session
		 *
		 * @return void;
		 */		
	public function GenerateSession(){
		if (!isset($_SESSION['security']['csrf'])) {
  			$_SESSION['security']['csrf'] = [];
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
    	if(isset($_SESSION['security']['csrf'][$token])){
    		return $_SESSION['security']['csrf'][$token];
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
    	if(isset($_SESSION['security']['csrf'][$token])){
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
  		if(isset($_SESSION['security']['csrf'])){
  			return end($_SESSION['security']['csrf']);
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
  		if(isset($_SESSION['security']['csrf'])){
  			return count($_SESSION['security']['csrf']);
  		}else{
  			return 0;
  		}
  	}
}