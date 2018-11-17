<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Common;

class FTP{

    /*
     * Connection
    */	
	private $connection;

    /*
     * connectionString
    */	
	private $connectionString;

    /**
     * Instantiate the FTP object
     * 
     * @param $host server host
     *        $user username 
     *        $pass password
     *        $secured ftp or ftps 
     *
     * @return boolean
     */
	public function __construct($host,$user,$pass,$secured){
		if($secured === false) {
			$conn = ftp_connect($host);
			$login_result = ftp_login($conn, $user, $pass);
			$this->connection = $conn;
			$this->connectionString = 'ftp://' . $user . ':' . $pass . '@' . $host;
		} elseif($secured === true) {
			$conn = ftp_ssl_connect($host);
			$login_result = ftp_login($conn, $user, $pass);
			$this->connection = $conn;
			$this->connectionString = 'ftps://' . $user . ':' . $pass . '@' . $host;
		} else {
			$this->connection = null;
			$this->connectionString = null;
		} 	
	}
    /**
     * get the connection.
     * 
     * @return resource
     */	
	public function getConnection()
	{
		return $this->connection;
	}
    /**
     * check whether the ftp is connected.
     *
     * @return boolean
     */	
	public function isConnected()
	{
		return (is_resource($this->getConnection()) ? true : false;
	}
    /**
     * get the list of files.
     * 
     * @param $dir directory
     *
     * @return boolean | array
     */
	public function ftpFiles($dir){
		return ($this->isConnected() === true) ? ftp_nlist($this->getConnection(),$dir) : false;
	}
    /**
     * get the current working directory.
     *
     * @return boolean | array
     */	
    public function pwd()
    {
    	return ($this->isConnected() === true) ? ftp_pwd($this->getConnection()) : false; 
    }
    /**
     * Change directories.
     * 
     * @param $dir directory
     *        $new naw name 
     *
     * @return boolean
     */
    public function chdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_chdir($this->getConnection(), $dir) : false;
    }
    /**
     * Make directory.
     * 
     * @param $dir directory name
     *
     * @return boolean
     */
    public function mkdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_mkdir($this->getConnection(), $dir) : false;    }
    /**
     * Make nested sub-directories
     *
     * @param  string $dirs
     * @return Ftp
     */
    public function mkdirs($dirs)
    {
        if (substr($dirs, 0, 1) == '/') {
            $dirs = substr($dirs, 1);
        }
        if (substr($dirs, -1) == '/') {
            $dirs = substr($dirs, 0, -1);
        }
        $dirs   = explode('/', $dirs);
        $curDir = $this->connectionString;
        foreach ($dirs as $dir) {
            $curDir .= '/' . $dir;
            if (!is_dir($curDir)) {
                $this->mkdir($dir);
            }
            $this->chdir($dir);
        }
        return $this;
    }
    /**
     * Remove directory.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function rmdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->getConnection(), $dir) : false; 
    }
    /**
     * Check if file exists.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function fileExists($file)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString. $file) : false;     	
    }
    /**
     * Check is the dir is exists.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function dirExists($dir)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString. $dir) : false; 
    }
    /**
     * Get the file.
     * 
     * @param $local local
     *        $remote remote 
     *        $mode mode
     *
     * @return boolean
     */
    public function get($local, $remote, $mode = FTP_BINARY)
    {
    	return ($this->isConnected() === true) ? ftp_get($this->getConnection(), $local, $remote, $mode) : false;
    }
    /**
     * Rename file.
     * 
     * @param $old old
     *        $new naw name 
     *
     * @return boolean
     */
    public function rename($old, $new)
    {
    	return ($this->isConnected() === true) ? ftp_rename($this->getConnection(), $old,$new) : false;
    }
    /**
     * Change premission.
     * 
     * @param $file file
     *        $mode mode
     *
     * @return boolean
     */
    public function chmod($file, $mode)
    {
    	return ($this->isConnected() === true) ? ftp_chmod($this->getConnection(), $mode , $file) : false; 
    }
    /**
     * Delete the files.
     * 
     * @param $file file you want to delete
     *
     * @return boolean
     */
    public function delete($file)
    {
    	return ($this->isConnected() === true) ? ftp_delete($this->getConnection(), $file) : false;
    }
    /**
     * Switch the passive mod.
     * 
     * @param $flag flag
     *
     * @return boolean
     */
    public function pasv($flag = true)
    {
    	return ($this->isConnected() === true) ? ftp_pasv($this->getConnection(), $flag) : false;
    }
    /**
     * Close the FTP connection.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            ftp_close($this->connection);
        }
    }
    /**
     * Upload the files.
     * @param $files number of files you want to uplaod
     * 		  $root Server root directory or sub	
     *
     * @return mix-data
     */
	public function put($files,$root = 'public_html'){
		if ($this->isConnected() === true) {
			foreach ($files as $key => $value) {
				ftp_put($this->getConnection(), $server_root.'/'.$value, $value, FTP_ASCII);
			}
		} else{
			return false;
		}
	}
}<?php

/**
 * This file is part of the Zest Framework.
 *
 * @author   Malik Umer Farooq <lablnet01@gmail.com>
 * @author-profile https://www.facebook.com/malikumerfarooq01/
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 * @license MIT
 */

namespace Zest\Common;

class FTP{

    /*
     * Connection
    */	
	private $connection;

    /*
     * connectionString
    */	
	private $connectionString;

    /**
     * Instantiate the FTP object
     * 
     * @param $host server host
     *        $user username 
     *        $pass password
     *        $secured ftp or ftps 
     *
     * @return boolean
     */
	public function __construct($host,$user,$pass,$secured){
		if($secured === false) {
			$conn = ftp_connect($host);
			$login_result = ftp_login($conn, $user, $pass);
			$this->connection = $conn;
			$this->connectionString = 'ftp://' . $params['username']user '@' . $host;
		} elseif($secured === true) {
			$conn = ftp_ssl_connect($host);
			$login_result = ftp_login($conn, $user, $pass);
			$this->connection = $conn;
			$this->connectionString = 'ftps://' . $params['username']user '@' . $host;
		} else {
			$this->connection = null;
			$this->connectionString = null;
		} 	
	}
    /**
     * get the connection.
     * 
     * @return resource
     */	
	public function getConnection()
	{
		return $this->connection;
	}
    /**
     * check whether the ftp is connected.
     *
     * @return boolean
     */	
	public function isConnected()
	{
		return (is_resource($this->getConnection()) ? true : false;
	}
    /**
     * get the list of files.
     * 
     * @param $dir directory
     *
     * @return boolean | array
     */
	public function ftpFiles($dir){
		return ($this->isConnected() === true) ? ftp_nlist($this->getConnection(),$dir) : false;
	}
    /**
     * get the current working directory.
     *
     * @return boolean | array
     */	
    public function pwd()
    {
    	return ($this->isConnected() === true) ? ftp_pwd($this->getConnection()) : false; 
    }
    /**
     * Change directories.
     * 
     * @param $dir directory
     *        $new naw name 
     *
     * @return boolean
     */
    public function chdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_chdir($this->getConnection(), $dir) : false;
    }
    /**
     * Make directory.
     * 
     * @param $dir directory name
     *
     * @return boolean
     */
    public function mkdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_mkdir($this->getConnection(), $dir) : false;    }
    /**
     * Make nested sub-directories
     *
     * @param  string $dirs
     * @return Ftp
     */
    public function mkdirs($dirs)
    {
        if (substr($dirs, 0, 1) == '/') {
            $dirs = substr($dirs, 1);
        }
        if (substr($dirs, -1) == '/') {
            $dirs = substr($dirs, 0, -1);
        }
        $dirs   = explode('/', $dirs);
        $curDir = $this->connectionString;
        foreach ($dirs as $dir) {
            $curDir .= '/' . $dir;
            if (!is_dir($curDir)) {
                $this->mkdir($dir);
            }
            $this->chdir($dir);
        }
        return $this;
    }
    /**
     * Remove directory.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function rmdir($dir)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->getConnection(), $dir) : false; 
    }
    /**
     * Check if file exists.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function fileExists($file)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString. $file) : false;     	
    }
    /**
     * Check is the dir is exists.
     * 
     * @param $dir directory
     *
     * @return boolean
     */
    public function dirExists($dir)
    {
    	return ($this->isConnected() === true) ? ftp_rmdir($this->connectionString. $dir) : false; 
    }
    /**
     * Get the file.
     * 
     * @param $local local
     *        $remote remote 
     *        $mode mode
     *
     * @return boolean
     */
    public function get($local, $remote, $mode = FTP_BINARY)
    {
    	return ($this->isConnected() === true) ? ftp_get($this->getConnection(), $local, $remote, $mode) : false;
    }
    /**
     * Rename file.
     * 
     * @param $old old
     *        $new naw name 
     *
     * @return boolean
     */
    public function rename($old, $new)
    {
    	return ($this->isConnected() === true) ? ftp_rename($this->getConnection(), $old,$new) : false;
    }
    /**
     * Change premission.
     * 
     * @param $file file
     *        $mode mode
     *
     * @return boolean
     */
    public function chmod($file, $mode)
    {
    	return ($this->isConnected() === true) ? ftp_chmod($this->getConnection(), $mode , $file) : false; 
    }
    /**
     * Delete the files.
     * 
     * @param $file file you want to delete
     *
     * @return boolean
     */
    public function delete($file)
    {
    	return ($this->isConnected() === true) ? ftp_delete($this->getConnection(), $file) : false;
    }
    /**
     * Switch the passive mod.
     * 
     * @param $flag flag
     *
     * @return boolean
     */
    public function pasv($flag = true)
    {
    	return ($this->isConnected() === true) ? ftp_pasv($this->getConnection(), $flag) : false;
    }
    /**
     * Close the FTP connection.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            ftp_close($this->connection);
        }
    }
    /**
     * Upload the files.
     * @param $files number of files you want to uplaod
     * 		  $root Server root directory or sub	
     *
     * @return mix-data
     */
	public function put($files,$root = 'public_html'){
		if ($this->isConnected() === true) {
			foreach ($files as $key => $value) {
				ftp_put($this->getConnection(), $server_root.'/'.$value, $value, FTP_ASCII);
			}
		} else{
			return false;
		}
	}
}