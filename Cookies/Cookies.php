<?php
	/**
	 * PHP Cookie manipulation cclass
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link    https://github.com/Lablnet/PHP-Cookie-manipulation-Class
	 *
	 */
namespace Softhub99\Zest_Framework\Cookies;

class Cookies

{

	private $name; // name of cookie

	private $value; // value of cookie

	private $expire; // expire of cookie

	private $domain; // domain of cookie

	private $path; // path of cookie

	private $secure; // secure of cookie

	private $httponly; // httponly of cookie
	 /**
	 * __Construct set the default values
	 *
	 * @return void
	 */	 
	public function __construct(){

		$this->expire = 0;

		$this->domain = 'localhost';

		$this->path = '/';

		$this->secure = true;

		$this->httponly = false;

	}

	 /**
	 * Set the cookie value
	 *
	 * @param 
	 * $name of cookie
	 * $value of cookie
	 * $expire of cookie 
	 * $domain of cookie
	 * $secure of cookie
	 * $httponly of cookie
	 *
	 * @return boolean
	 */	 
	public static function Set($params){

		if(is_array($params)){

			if (preg_match("/[=,; \t\r\n\013\014]/", $params['name'])) {

			  	$this->name = rand(1, 25);

			}else{

			  	$this->name = $params['name'];

			}

       	 	if ($params['expire'] instanceof \DateTime) {


           	 	$expire = $expire->format('U');

           	
       	 	}elseif (!is_numeric($params['expire'])) {

             	$expire = strtotime($params['expire']);

        	}else{

        		$this->expire = $params['expire'];

        	}

        	
			$this->value = $params['value'];

			$this->domain = $params['domain'];

	        $this->path = empty($path) ? '/' : $params['path'];

	        $this->secure = (Boolean) $params['secure'];

	        $this->httponly = (Boolean) $params['httponly'];

	        return static::SetCookie();

		}else{

			return false;

		}

	}

	 /**
	 * Set the cookie value
	 *
	 * @return boolean
	 */	 
	public static function SetCookie(){

			if(!empty($this->name) && !empty($this->value) && !empty($this->expire) && !empty($this->path) && !empty($this->domain) && is_bool($this->secure) && is_bool($this->httponly)){

					if(static::IsCookie($this->name) === false){

						setcookie($this->name, $this->value, $this->expire, $this->path, $this->domain, $this->secure, $this->httponly);
				
						return true;

					}else{

						return false;

					}		

			}else{

				return false;

			}
	}

	 /**
	 * Check if cookie set or not
	 * @param  $name of cookie
	 *
	 * @return boolean
	 */	 
	public static function IsCookie($name){

		if(isset($name) && !empty($name)){

			if(isset($_COOKIE[$name])){

				return true;

			}else{

				return false;

			}

		}else{

			return false;

		}

	}

	 /**
	 * Get the cookie value
	 * @param  $name of cookie
	 *
	 * @return string | boolean
	 */	 
	public static function Get($name){

		if(isset($name) && !empty($name)){

			if(isset($_COOKIE[$name])){

				return $_COOKIE[$name];

			}else{

				return false;

			}

		}else{

			return false;

		}		

	}
	 /**
	 * Delete the cookie
	 * @param  $name of cookie
	 *
	 * @return boolean
	 */	 
	public static function Delete($name){

		if(isset($name) && !empty($name)){

			if(static::IsCookie($name)){

				$this->name = $name;

				$this->value = self::Get($name);;

				setcookie($this->name, $this->value, time() - 3600, $this->path, $_SERVER['SERVER_NAME']);

				return true;

			}else{

				return false;

			}

		}else{

			return false;

		}		

	}

}