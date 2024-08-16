<?php
define("MODE", "dev");
require __DIR__.'/../vendor/autoload.php';

use App\Exceptions\RouteException as RouteException;

class Route{
    public $path = "/";
    public $route = []; 
    public function __construct(){
        if(isset($_GET["_url"])){
            $this->path = $_GET["_url"];
        }
    }

    public function add($path, $config){
        $this->route[$path] = $config;
    }

    public function start(){
        try{
            if(isset($this->route[$this->path])){
                $controller = ucfirst($this->route[$this->path]["controller"]);
                $controller_name = "App\Controllers\\$controller"."Controller";
                $action_name = $this->route[$this->path]["action"]."Action";
    
                if (!class_exists($controller_name)) {
                    throw new RouteException("Controller not found ($controller_name)");
                }
    
                $instance = new $controller_name();
                if (!method_exists($instance, $action_name)) {
                    throw new RouteException("Action not found ($action_name) in controller ($controller_name)");
                }
                
                $instance->$action_name();
            }else{
                throw new RouteException("Route not found $this->path");
            }
        }catch(RouteException $err){
            view("error/404");
        }
        return;
    }
}

try{
    $route = new Route();

    $route->add("/", [
        "controller" => "index",
        "action" => "index"
    ]);
    
    $route->start();
}catch(Exception $err){
    $data = ["error" => $err];
    view("error/500", $data);
}



?>