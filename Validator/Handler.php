<?php 
namespace Softhub99\Zest_Framework\Validator;

class Handler 
{
	/**
     * Store errors
     */
	protected static $errors;
    /**
     * __construct
     */
	public function __construct(){
		static::$errors = [];
	}
    /**
     * Return true if there is validation error
     * @param 
     * $error => error msg
     * $key => error key
     */	
	public static function set($error,$key = null){
        if (isset($key)) {
            static::$errors[$key] = $error;
        } else {
            static::$errors = $error;
        }
	}
    /**
     * Return true if there is validation error
     *
     * @return bool
     */	
	public static function has(){
		return (isset(static::$errors) && static::$errors > 0) ? true : false;
	}	
    /**
     * return all errors
     *
     * @return array
     */	
	public function all(){
		return static::$errors;
	}
    /**
     * Set and returns default custom validation messages
     *
     * @param array $custom
     * @return array
     */
    public static function getValidationMessages($custom = [])
    {
        $Msgs = Msgs::msgs;

        foreach ($custom as $key => $value){
            if(array_key_exists($key, $Msgs))
            {
                $Msgs[$key] = $value;
            }
        }
        return $Msgs;
    }

}