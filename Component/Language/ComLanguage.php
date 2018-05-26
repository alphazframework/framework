<?php
namespace Softhub99\Zest_Framework\Component\Language;
use Softhub99\Zest_Framework\Cookies\Cookies;
use Softhub99\Zest_Framework\Str\Str;
Class ComLanguage
{

		/**
		 * set the language
		 * @param $value=> language symbol 
		 *
		 * @return string
		 */	
	public static function setLanguage($value){
		Cookies::set(['name'=>'lang','expir'=>time()+100000,'value'=>$value,'domain'=>$_SERVER['SERVER_NAME'],'path'=>'/','secure'=>false,'httponly'=>false]);
	}
		/**
		 * Get the current language
		 * 
		 * @return string
		 */		
	public static function getLang(){
		if(Cookies::isCookie('lang')){
			$language = Cookies::get('lang');
	  	}else{
		$language = \Config\Config::Language;
	  	}
	  	return $language;
	}	
		/**
		 * include lang string file
		 * 
		 * @return string
		 */			
	public static function comlanguageString(){
			$data = [];
			$language = static::getLang();
			$path = "../App/Components/";
			$disk_scan = array_diff(scandir($path),array('..','.'));
			foreach($disk_scan as $scans){
				require_once "../App/Components/".$scans."/local/{$language}.php";
				if(is_array($GLOBALS['lang'])){
					$data += $GLOBALS['lang'];
				}else{
					return [];
				}
			}
			return $data;
		}			
		/**
		 * for getting language key and return its value
		 * @param $key language key
		 * @return string
		 */
	public static function printC($key){
		if(!empty($key)){
				return static::comlanguageString()[Str::stringConversion($key,'lowercase')];
		}else{
			return false;
		}
	}
		/**
		 * Only for debug purpose
		 * 
		 * @param =>$params (array)
		 * 'allkeys'=>'on' ==> return all keys in array
		 * 'search' => 'value' ==> return boolean true on find false not find Note: it only keys string in language file
		 * @return string
		 */		
	public static function debug($params){
		if(is_array($params)){
			if(isset($params['allkeys']) and Str::stringConversion($params['allkeys'],'lowercase') === 'on'){
				return array_keys($this->comlanguageString());
			}
			if(isset($params['search'])){
			   if( array_key_exists($params['search'], $this->comlanguageString())){
			        return true;        
			    }else{
			        return false;
			    }
			}
		}else{
			return false;
		}
	}
}
