<?php
	/**
	 * PHP Site class
	 *
	 * @author   Malik Umer Farooq <lablnet01@gmail.com>
	 * @author-profile https://www.facebook.com/malikumerfarooq01/
	 * @license MIT 
	 * @link    https://github.com/Lablnet/PHP-Site-class
	 *
	 */
namespace Softhub99\Zest_Framework\Site;

class Site

{

		/**
		 * Return site URL
		 * 
		 * @access public
		 * @return string
		 */	
	public static function SiteUrl(){

		    $base_url = Site::GetProtocol() . Site::GetServerName() . ':' . Site::GetPort() . Site::GetUri();

			return $base_url;

	}
		/**
		 * Return Current Page
		 * 
		 * @access public
		 * @return string
		 */		
	public static function CurrentPage(){

		    $base_url = Site::GetUri();

			return $base_url;

	}	
    /**
     * Get the domain protocol.
     *
     * @access public    
     * @return string
     */	
	public static function GetProtocol(){

		if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {

			$protocol = 'http://';

		} else {

			$protocol = 'https://';

		}		

		return $protocol;
			
	}	


    /**
     * Get the server name.
     *
     * @access public    
     * @return string
     */
     public static function GetServerName(){

     	if(isset($_SERVER['SERVER_NAME'])){

     		return $_SERVER['SERVER_NAME'];

     	}else{

     		return false;

     	}

     }	
    /**
     * Get the server port.
     *
     * @access public
     * @return int
     */	
    public static function GetPort()
    {
        return $_SERVER['SERVER_PORT'];
    }
    /**
     * Get script path like example.com/login.
     *
     * @access public
     * @return string example.com/login
     */
    public static function GetUri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

	/**
	 * Redirect to another page
	 *
	 * @param (string) $url optional 
	 * self => itself page
	 * else => any page you want
	 * 
     * @access public
	 * @return void
	 */
	public static function Redirect( $url = null ){

		if($url === null or empty($url)){

			$base_url = self::SiteUrl();

		}elseif($url === 'self' or isset($_SERVER['HTTP_REFERER'])) {

	        $base_url = Site::previous();

	    }elseif($url !== 'self' && $url !== null){

	    	$base_url = Site::SiteUrl().$url;

	    }else{

			$base_url = $url;

		}

		header("Location:".$base_url);

	}
	/**
	* Go to the previous URL.
	* @access private
	* @return void
	*/	
    private static function Previous()
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }	
    /**
     * Get all URL parts based on a / seperator.
     *
     * @param string $url → URI to segment
     *
     * @access public
     * @return string
     */
    public static function SegmentUrl($url = null)
    {
       	if(!is_null($url) && !empty($url)){

       		$url = $url;

       	}else{

       		$url = $_SERVER['REQUEST_URI'];

       	}

        return explode('/', trim($url, '/'));
    }  
    /**
     * Get first item segment.
     *
     * @access public     
     * @return string
     */
    public static function GetFirstSegment($segments)
    {
        if(is_array($segments)){

        	$vars = $segments;

        }else{

        	$vars = Site::SegmentUrl($segments);

        }

        return current($vars);
    }

    /**
     * Get last item segment.
     *
     * @return string
     * @access public    
     */
    public static function GetLastSegment($segments)
    {
        if(is_array($segments)){

        	$vars = $segments;

        }else{

        	$vars = Site::SegmentUrl($segments);

        }

        return end($vars);
    }      	

	/**
	* generate salts for files
	* 
	* @param string $length length of salts
    * @access public	
	* @return string
	*/
	public static function Salts($length){
		
		$chars =  array_merge(range(0,9), range('a', 'z'),range('A', 'Z'));

		$stringlength = count( $chars  ); //Used Count because its array now
		
		$randomString = '';
		
		for ( $i = 0; $i < $length; $i++ ) {
			
			$randomString .= $chars[rand( 0, $stringlength - 1 )];
			
		}
		
		return $randomString;
		
	}

}
