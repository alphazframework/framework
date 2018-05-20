<?php
namespace Softhub99\Zest_Framework\Str;
class Str
{ 
     /**
     * Remove abusive/anytype of word in the string or user input
     * @param  $params (array)
     * 'search' =>  word need to search either come form database or you 
     * written in array
     * 'replace' => Word need to replace with these words
     * 'text' => User input or anyString
     * ISSUE: text uppercase and lowercase issues
     * @return string
    */	
	public function replaceWords($search,$replace,$text){			
		return str_replace($search, $replace,$text);		
	}
	 /**
     * Convert uppercase to lower & lowercase to upper
     * @param   $params (array)
     * 'type' => possible uppercase and lowercase
     * 'text' => string to conversion
     * @return string
    */	
	public function stringConversion( $text , $type ){
		if($type === 'lowercase'){
			return strtolower($text);
		}elseif($type === 'uppercase'){
			return strtoupper($text);
		}
		if($type === 'camelcase'){
			return ucwords($text);	
		}
	}
}

