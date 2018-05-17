<?php

namespace Softhub99\Zest_Framework\View;
Class View{

	//file
	private static $file;
	//key for template data
	private static $keys = [];
	//value for template data
	private static $Values = [];
	/**
	 * Set file
	*
	* @param $file name of files
	*
	 * @return void
	 */		
	private static function SetFile($file){
		 $file = "../App/Views/".$file;
		if(file_exists($file)){
			static::$file = $file;
		}else{
			return false;
		}
	}
	/**
	 * Set attributes for template
	*
	* @param $arrays
	*
	 * @return booleans
	 */			
	public static function SetTemplate($file,$params = []){
		if(!empty($file)){
			static::SetFile($file);
		}else{
			return false;
		}
				$keys = array_keys($params);
				$value = array_values($params);
				static::$keys = $keys;
				static::$Values = $value;
				return static::Rander();
	}
		
	/**
	 * Get content form file
	*
	 * @return raw-data
	 */			
	public static function FetchFile(){
		if(static::IsFile()){
			 $file = static::$file;
			return file_get_contents($file);	
		}else{
			return false;
		}	

	}

	/**
	 * Check file exists or not
	*
	 * @return boolean
	 */	
	public static function IsFile(){
		$file = static::$file;
		if(file_exists($file)){
			return true;
		}else{
			return false;
		}


	}	
	/**
	 * Rander template
	*
	 * @return raw-data
	 */		
	public static function Rander(){
		$file = static::FetchFile();
		$CountKeys = count(static::$keys);
		$CountValues = count(static::$Values);
		if($CountKeys === $CountValues && static::IsFile()){
			$counter = $CountKeys = $CountValues;
			for ( $i = 0; $i<$counter; $i++){
				$keys = static::$keys[$i];
				$values = static::$Values[$i];
				$tag = "{% $keys %}";
				$pattern = "/$tag/";
				$file =  preg_replace("/$tag/i", $values, $file);		
			}
			return $file;	

		}else{
			return false;
		}

	}	

	public function View($file){
		if(!empty($file)){
			$file = "../App/Views/".$file.'.php';
			if(file_exists($file)){
				require_once $file;
			}else{
				return false;
			}
		}else{
			return false;			
		}	
	}		
}