<?php
namespace Softhub99\Zest_Framework\Language;
use Softhub99\Zest_Framework\Cookies\Cookies;
use Softhub99\Zest_Framework\Str\Str;
Class Language
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
	public static function languageString(){
			$language = static::getLang();
		  if(file_exists("../local/{$language}.php")){
			 require_once "../local/{$language}.php";
			if(is_array($GLOBALS['lang'])){
				return $GLOBALS['lang'];
			}else{
				return [];
			}}else{
				return false;
			}
		}	
		/**
		 * for getting language key and return its value
		 * @param $key language key
		 * @return string
		 */
	public static function print($key){
		if(!empty($key)){

			if(array_key_exists(Str::stringConversion($key,'lowercase'),static::languageString())){
				return static::languageString()[Str::stringConversion($key,'lowercase')];
			}else{
				return Str::stringConversion($key,'lowercase');
			}
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
				return array_keys($this->languageString());
			}
			if(isset($params['search'])){
			   if( array_key_exists($params['search'], $this->languageString())){
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
