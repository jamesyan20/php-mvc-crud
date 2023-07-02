<?php

class Router {
	private static $controllerNamespace='App\\Controllers\\';

	public static $routes = [
		'GET'  => [],
		"POST" => [],
		"DELETE" => [],
		"PATCH" => [],
		"OPTIONS" => [],
		"PUT" => []
	];
	

	public static function get( $uri, $controller ) {
		
		return self::$routes["GET"][ trim($uri,'/') ] = $controller;
	}
	
	public static function post( $uri, $controller ) {
		
		return self::$routes["POST"][ trim($uri,'/') ] = $controller;
	}

    public static function load($files=[] ) {
	    $instance = new static();

        foreach ($files as $file) {
         require_once $file;
		}
		return $instance;
	}
	
	public static function direct( $uri,$requestType ) {

	    if(!isset(self::$routes[$requestType])){
	        http_response_code(503);
            header('Content-type:application/json');
            echo json_encode(['status'=>'error','message'=>'Bad Request.'.$requestType,
                'code'=>503]);
			return 1;        
		}	
		if(array_key_exists(trim($uri,'/'),self::$routes[$requestType])){
			return static::map(
				...explode('@',
				self::$routes[$requestType][$uri]
				));
			
		}
		//return an error general page
		view("errors/404");
		return 1;
	}
    protected static function map($controller, $action){
		$controller=(self::$controllerNamespace.$controller);

		$controller=new $controller;	

		if(!method_exists($controller,$action)){
			//return an error page
			view("errors/500");
			return 1;
		}
		
		return $controller->$action();
		
	}

}
