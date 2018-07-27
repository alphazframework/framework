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
 *
 */

namespace Softhub99\Zest_Framework\Router; 
use Softhub99\Zest_Framework\Router\Router;
class App 
{
	
	public function run()
	{
		$router = new Router;
		if (\Config\Config::ROUTER_CACHE){
			if ($this->isExpired()) {
				$this->delete();
				require_once '../routes/routes.php';
			} else {
				$router->routes = $router->loadCache();
				$router->dispatch($_SERVER['QUERY_STRING']);
			}
		} else {
			require_once '../routes/routes.php';
		}
	}
	public function isExpired()
	{
		$f = fopen('../Storage/Cache/router_time.cache','r');
		$expire = fread($f, filesize('../Storage/Cache/router_time.cache'));
		fclose($f);
		if ($expire <= time()) {
			return true;
		} else {
			return false;
		}
	}
	public function delete()
	{
		unlink("../Storage/Cache/routers.cache");
		unlink("../Storage/Cache/router_time.cache");
	}
}