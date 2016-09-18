<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 17.09.2016
 * Time: 18:33
 */
class Route
{
    static function start()
    {
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($routes);

        $keys = ["controller", "action", "p1", "p2", "p3", "p4"];
        $stuffed_routes = [];
        foreach($keys as $i => $param){
            $val = "";
            if(!empty($routes[$i])) $val = $routes[$i];
            $stuffed_routes[$param] = $val;
        }
        extract($stuffed_routes);

        if(empty($controller))  $controller = 'main';
        if(empty($action))      $action = 'index';

        $controller = strtolower($controller);

        $path_controller = ROOT_PATH . "app/controllers/{$controller}.php";

        if(!is_file($path_controller))
            throw new MyException("Not found controller: $path_controller", 1000);

        require $path_controller;

        $controller_name = 'Controller'.ucfirst($controller);
        $Controller = new $controller_name;

        if(!method_exists($Controller, $action))
            throw new MyException("Not found method: $action", 1001);

        $Controller->$action($p1, $p2, $p3, $p4);
    }
}