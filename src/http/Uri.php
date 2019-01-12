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
 * @since 3.0.0
 *
 * @license MIT
 */

namespace Zest\http;

class Uri extends Message
{

	public function __construct()
	{
        parent::__construct();
	}

    /**
     * Set the Uri.
     *
     * @param $url valid url
     *        $host valid host 
     *		  $port valid port number	
     *		  $path valid path
     *		  $query query URI
     *		  $fragment fragment
     *        $user username
     *        $password password
     *
     * @since 3.0.0
     *
     * @return object
     */
	public function setUri($scheme,$host,$port = null,$path = '/',$query = '', $fragment = '',$user = '',$password = '') 
	{
        $this->scheme = $this->filterScheme($scheme);
        $this->host = $host;
        $this->port = $this->filterPort($port);
        $this->path = empty($path) ? '/' : $this->filterQuery($path);
        $this->query = $this->filterQuery($query);
        $this->fragment = $this->filterQuery($fragment);
        $this->user = $user;
        $this->password = $password;	

        return $this;
	}

    /**
     * Get the scheme component of the URL.
     *
     * @param $url valid url
     *
     * @since 3.0.0
     *
     * @return object
     */	
	public function createFormUrl($url)
	{
		$urlParts = parse_url($url);

        $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'] : '';
        $user = isset($urlParts['user']) ? $urlParts['user'] : '';
        $password = isset($urlParts['pass']) ? $urlParts['pass'] : '';
        $host = isset($urlParts['host']) ? $urlParts['host'] : '';
        $port = isset($urlParts['port']) ? $urlParts['port'] : null;
        $path = isset($urlParts['path']) ? $urlParts['path'] : '';
        $query = isset($urlParts['query']) ? $urlParts['query'] : '';
        $fragment = isset($urlParts['fragment']) ? $urlParts['fragment'] : '';

        $this->setUri($scheme,$host,$port,$path,$query,$fragment,$user,$password);

        return $this;
	}

    /**
     * Filter the url scheme component.
     *
     * @param $scheme valid scheme
     *
     * @since 3.0.0
     *
     * @return string
     */	
	public function filterScheme($scheme)
	{
		$valids = [
			'' => true,
			'http' => true,
			'https' => true,
		];
        $scheme = str_replace('://', '', strtolower((string)$scheme));
        if (!isset($valids[$scheme])) {
            throw new \InvalidArgumentException('Uri scheme must be one of: "", "https", "http"');
        }

        return $scheme;		
	}

    /**
     * Filter port.
     *
     * @param $port port number
     *
     * @since 3.0.0
     *
     * @return string
     */	
	public function filterPort($port)
	{
		if (is_null($port) || is_integer($port)) {
			return $port;
			
		}
		throw new \InvalidArgumentException('Uri port much be type int');	
	}

    /**
     * Filter the Query uri.
     *
     * @param $query query uri
     *
     * @since 3.0.0
     *
     * @return string
     */	
	public function filterQuery($query)
	{
		return rawurlencode($query);
	}

    /**
     * Get the scheme component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Get determined scheme.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getDeterminedScheme()
    {
        return ($this->isSecure()) ? 'https' : 'http';
    }


    /**
     * Get the authority component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getAuthority()
    {
    	return ($this->getUserInfo() !== '') ? $this->getUserInfo() . 
    	'@' : '' . $this->getHost() . ($this->getPort() !== '') ? ':' . $this->getPort() : '';   
    }

    /**
     * Get the user information component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getUserInfo()
    {
    	return ($this->user !== '') ? $this->user : '' . ($this->password !== '') ? ':' . $this->password : '';   
    }

    /**
     * Get the host component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getHost()
    {
    	return $this->host;
    }

    /**
     * Get the path component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getPath()
    {
    	return $this->path;
    }

    /**
     * Get the port component of the URL.
     *
     * @since 3.0.0
     *
     * @return int
     */
    public function getPort()
    {
    	return $this->port;
    }

    /**
     * Get the query string of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getQuery()
    {
    	return $this->query;
    }

    /**
     * Get the fragment component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getFragment()
    {
    	return $this->fragment;
    }  

    /**
     * Get the basePath segment component of the URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getBasePath()
    {
    	return $this->basePath;
    }

    /**
     * Return an instance with the specified user information.
     *
     * @param $user username
     *        $password password 
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withUserInfo($user, $password = null)
    {
    	$this->user = $user;
    	$this->password = $password;

    	return $this;
    }

    /**
     * Return an instance with the specified host.
     *
     * @param $host valid host
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withHost($host)
    {
    	$this->host = $host;

    	return $this;
    }

    /**
     * Return an instance with the specified path.
     *
     * @param $path valid path
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withPath($path)
    {    	
        // if the path is absolute, then clear basePath
        if (substr($path, 0, 1) == '/') {
            $clone->basePath = '';
        }
        $this->path = $this->filterQuery($path);

    	return $this;
    }

    /**
     * Return an instance with the specified port.
     *
     * @param $port valid port
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withPort($port)
    {
    	$this->port = $this->filterPort($port);

    	return $this;
    }

    /**
     * Return an instance with the specified query.
     *
     * @param $query valid query
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withQuery($query)
    {
    	$this->query = $this->filterQuery(ltrim($query,"?"));

    	return $this;
    }

    /**
     * Return an instance with the specified fragment.
     *
     * @param $fragment valid fragment
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withFragment($fragment)
    {
    	$this->fragment = $this->filterQuery(ltrim($fragment,"#"));

    	return $this;
    } 

    /**
     * Return an instance with the specified basePath segment.
     *
     * @param $fragment valid fragment
     * 
     * @since 3.0.0
     *
     * @return object
     */
    public function withBasePath($basePath)
    {
    	$this->basePath = $this->filterQuery($basePath);

    	return $this;
    } 

 	public function __toString()
 	{
        $scheme = $this->getScheme();
        $authority = $this->getAuthority();
        $basePath = $this->getBasePath();
        $path = $this->getPath();
        $query = $this->getQuery();
        $fragment = $this->getFragment();

        $path = $basePath . '/' . ltrim($path, '/');

        return ($scheme !== '' ? $scheme . ':' : '')
            . ($authority !== '' ? '//' . $authority : '')
            . $path
            . ($query !== '' ? '?' . $query : '')
            . ($fragment !== '' ? '#' . $fragment : ''); 		
 	}

    /**
     * Get the fully qualified base URL.
     *
     * @since 3.0.0
     *
     * @return string
     */
    public function getBaseUrl()
    {
        $scheme = $this->getScheme();
        $authority = $this->getAuthority();
        $basePath = $this->getBasePath();

        if ($authority !== '' && substr($basePath, 0, 1) !== '/') {
            $basePath = $basePath . '/' . $basePath;
        }

        return ($scheme !== '' ? $scheme . ':' : '')
            . ($authority ? '//' . $authority : '')
            . rtrim($basePath, '/');
    }
}