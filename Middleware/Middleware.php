<?php
namespace Softhub99\Zest_Framework\Middleware;

class Middleware
{
	
	final public function run($type,$middleware,$params='null',$namespace='App\Middleware\\')
	{
		if(!empty($type) && !empty($middleware)){
			$file = "../App/Middleware/{$middleware}.php";
			if(empty($namespace)){
				$namespace = "App\Middleware\\";
			}else{
				$namespace = $namespace;
			}
			if(file_exists($file)){
				$middleware = $middleware;
				$middleware = $namespace.$middleware;
				if(class_exists($middleware)){
					$middleware_obj = new $middleware;
					if($type === 'before'){
						if(method_exists($middleware_obj, 'before')){
							$middleware_obj->before($params);
						}else{
							throw new \Exception("Middleware method not exists", 404);		
						}
					}
					if($type === 'after'){
						if(method_exists($middleware_obj, 'after')){
							$middleware_obj->after($params);
						}else{
							throw new \Exception("Middleware method not exists", 404);
						}
					}					
				}else{
					throw new \Exception("Middleware {$middleware} class not found", 404);
				}
			}else{	
				throw new \Exception("Middleware {$middleware} not found", 404);
			}
		}else{	
			throw new \Exception("Error unknown middleware", 404);			
		}
	}
}