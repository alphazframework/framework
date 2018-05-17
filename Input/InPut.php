<?php
namespace Softhub99\Zest_Framework\Input;
class InPut

{
	private static $method;
	public function __construct(){}
	 /**
	 * Wordwrap
	 * @param  $str Str to be wordwraped
	 *
	 * @return string | boolean
	 */	 
	public static function WordWrapEnable($str,$width){
			if(!empty($str) && !empty($width) &&  $width >= 1 ){
				return wordwrap($params['str'], $params['width'], '<br />\n');
			}else{
				return false;
			}
	}
	 /**
	 * Check form sbumit or not
	 * @param  $name => name of submit button/ field
	 *
	 * @return boolean
	 */	 
	public static function IsFromSubmit($name){
			if(isset($_REQUEST[$name])){
				return true;
			}else{
				return false;
			}
	}
	 /**
	 * Accpet input
	 * Support get.post,put
	 *
	 * @param  $params 
	 * 'name' => name of filed (required in get,post request)
	 *
	 * @return string | boolean
	 */	 
	public static function Input ( $key ) {
			InPut::$method =  $_SERVER['REQUEST_METHOD'];
			if(isset(InPut::$method) && !empty(InPut::$method)){
				if(isset($key) && !empty($key)){
					if(InPut::$method === 'POST' && isset($_POST[$key])){
						$string = $_POST["$key"];
					}elseif(InPut::$method === 'GET' && isset($_GET[$key])){
						$string = $_GET[$key];
					}elseif(InPut::$method === 'PUT'){
						 parse_str(file_get_contents('php://input'), $_PUT);
						$string = $_PUT[$key];
					}elseif(InPut::$method === 'DELETE'){
						parse_str(file_get_contents('php://input'), $_DEL);
						$string = $_DEL[$key];
					}else{
						if(isset($_REQUEST[$key])){
							$string = $_REQUEST[$key];
						}
					}
					if(isset($string) && !empty($string)){
						return $string;
					}else{
						return false;
					}
				}
			}
	}
	 /**
	 * Clean input
	 *
	 * @param  $params 
	 * 'input' => string 
	 * 'type' => secured , root
	 *
	 * @return string | boolean
	 */	 
	public static function Cleane($input,$type){
			if(!empty($input)){
				if(!empty($type)){
					if($type === 'secured'){
				        return  stripslashes(trim(htmlspecialchars(htmlspecialchars($params['input'],ENT_HTML5),ENT_QUOTES)));
					}elseif($type === 'root'){
						return  stripslashes(trim(htmlspecialchars(htmlspecialchars(strip_tags($params['input']),ENT_HTML5),ENT_QUOTES)));
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
	}
	 /**
	 * Restore new lines
	 *
	 * @param  $params 
	 * 'str' => string that tobe restored new lines
	 *
	 * @return string | boolean
	 */	 
	public static function RestoreLineBreaks($str) {
			if(isset($str) and strlen($str) !== 0){			
				$result =  str_replace(PHP_EOL, "\n\r<br />\n\r", $params['str']);
				return $result;
			}else{
				return false;
			}
	}
	 /**
	 * Check request ajax or not
	 *
	 * @return string | boolean
	 */	 
	public static function IsAjax(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'){
			return true;
		}else{
			return false;
		}
	}
}