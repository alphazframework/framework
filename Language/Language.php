<?php
namespace Softhub99\Zest_Framework\Language;
use Softhub99\Zest_Framework\Cookies\Cookies;
Class Language
{

		/**
		 * set the language
		 * @param $value=> language symbol 
		 *
		 * @return string
		 */	
	public static function SetLanguage($value){
		Cookies::Set(['name'=>'lang','expir'=>time()+100000,'value'=>$value,'domain'=>$_SERVER['SERVER_NAME'],'path'=>'/','secure'=>false,'httponly'=>false]);
	}
		/**
		 * Get the current language
		 * 
		 * @return string
		 */		
	public static function GetLang(){
		if(Cookies::IsCookie('lang')){
			$language = Cookies::Get('lang');
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
	public static function LanguageString(){
			$language = static::GetLang();
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
	public static function Print($key){
		if(!empty($key)){
			if(array_key_exists(strtolower($key),static::LanguageString())){
				return static::LanguageString()[strtolower($key)];
			}else{
				return strtolower($key);
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
	public static function Debug($params){
		if(is_array($params)){
			if(isset($params['allkeys']) and strtolower($params['allkeys']) === 'on'){
				return array_keys($this->LanguageString());
			}
			if(isset($params['search'])){
			   if( array_key_exists($params['search'], $this->LanguageString())){
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
