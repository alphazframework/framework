<?php

namespace Softhub99\Zest_Framework\Session;
class Session
{

	 /**
     * __Construct
     * @return void
    */
	public function __construct(){
		self::Start();
	}

	 /**
     * Start the session if not already start
     * @return void
    */
	public function Start():void{
		if(session_status() === PHP_SESSION_NONE){
			session_start();
			return;
		}else{
			return;
		}
	}
     /** 
     *Change session path
	 *
     * @return void
    */		
	public function SessionPath () :void{
		$path = \Config\Config::Session_Path;
		ini_set('session.save_path', $path);
	}
     /** 
     *Check if session is already set with specific name
     * @param $name (string) name of session e.g users
     * @return boolean
    */
	public function CheckStatus(?string $name):bool{
		if(isset($_SESSION[$name])){
			return true;
		}else{
			return false;
		}
	}

     /**
     * Get the session value by providing session name
     * @param $name (string) name of session e.g users
     * @return string
    */
	public function GetValue(?string $name):string{
		if($this->CheckStatus($name) === true){
			return $_SESSION[$name];
		}else{
			return false;
		}
	}

     /**
     * Set/store value in session
     * @param $params (array) 
     * 'name' => name of session e.g users
     * 'value' => value store in session e.g user token 
     * @return string
    */
	public function SetValue(?array $params){
		if(is_array($params)){
			if($this->CheckStatus($params['name']) !== true){
				$_SESSION[$params['name']] = $params['value'];
				return $_SESSION[$params['name']];
			}else{
				return false;
			}
		}
	}

    /**
     * Delete/unset the session
     * @param $name (string) name of session e.g users
     * @return boolean
    */ 
	public function UnsetValue(?string $name):bool{
		if($this->CheckStatus($name) === true){
			session_unset($name);
			return true;
		}else{
			return false;
		}
	}
}