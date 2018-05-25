<?php

namespace Softhub99\Zest_Framework\Session;
class Session
{

     /**
     * __Construct
     * @return void
    */
    public function __construct(){
        static::sessionPath();
        static::start();
    }

     /**
     * Start the session if not already start
     * @return void
    */
    public static function start(){
        (session_status() === PHP_SESSION_NONE) ? session_start() : null;
    }
     /** 
     *Change session path
     *
     * @return void
    */      
    public static function sessionPath () {
        $path = \Config\Config::Session_Path;
        ini_set('session.save_path', $path);
    }
     /** 
     *Check if session is already set with specific name
     * @param $name (string) name of session e.g users
     * @return boolean
    */
    public static function isSession(string $name):bool{
        return (isset($_SESSION[$name])) ? true : false;
    }

     /**
     * Get the session value by providing session name
     * @param $name (string) name of session e.g users
     * @return string
    */
    public static function getValue(string $name)
    {
        return (static::isSession($name)) ? $_SESSION[$name] : false;
    }

     /**
     * Set/store value in session
     * @param $params (array) 
     * 'name' => name of session e.g users
     * 'value' => value store in session e.g user token 
     * @return string
    */
    public static function setValue(string $name,$value ){
        return (static::isSession($name) !== true) ? $_SESSION[$name] = $value : false;
    }

    /**
     * Delete/unset the session
     * @param $name (string) name of session e.g users
     * @return boolean
    */ 
    public static function unsetValue(string $name){
        return (static::isSession($name)) ? session_unset($name) : false;
    }
}