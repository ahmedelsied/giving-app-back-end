<?php
namespace lib\vendor;
use lib\vendor\class_factory;
use lib\vendor\requests;
class front_controller
{
    private $request;
    private $routes;
    public function __construct()
    {
        $this->request = class_factory::create_instance("lib\\vendor\\requests");
        $this->routes = class_factory::create_instance("lib\\vendor\\route");
        $this->get_registered_routes($this->request->uri);
        $this->init_request_lc();
    }
    //Method To Handle URL
    private function init_request_lc()
    {
        if($this->routes->has_middleware($this->request->method,$this->request->uri)){
            $this->routes->init_middleware($this->request->method,$this->request->uri,$this->request->body);
        }
        $requested_route = $this->routes->get_route($this->request->method,$this->request->uri);
        $controller = $this->routes->get_controller($requested_route);
        $controller = class_factory::create_instance("controllers\\$controller",[$this->request->body]);
        $method = $this->routes->get_method($controller,$requested_route);
        $this->dispatch($controller,$method);
    }
    //Method To Dispatch Controller
    public function dispatch($controller,$method)
    {
        $controller->$method();
    }
    private function get_registered_routes($request_uri)
    {
        $exist = false;
        foreach(explode("/",$request_uri) as $target){
            if(file_exists(ROUTES.$target.".php")){
                $exist = true;
                require_once ROUTES."$target.php";
            }
        }
        if(!$exist){
            http_response_code(404);
            exit();
        }
    }
}