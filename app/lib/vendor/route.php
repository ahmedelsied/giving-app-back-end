<?php
namespace lib\vendor;
use lib\vendor\class_factory;
class route
{
    private $routes_map = [
        "post"      => [],
        "get"       => [],
        "put"       => [],
        "delete"    => []
    ];
    private $current_used_url;
    private $last_request_method;
    public function post(string $url,string $target_path)
    {
        $this->set_route("post",$url,$target_path);
        return $this;
    }
    public function get(string $url,string $target_path)
    {
        $this->set_route("get",$url,$target_path);
        return $this;
    }
    public function put(string $url,string $target_path)
    {
        $this->set_route("put",$url,$target_path);
        return $this;
    }
    public function delete(string $url,string $target_path)
    {
        $this->set_route("delete",$url,$target_path);
        return $this;
    }
    public function middleware(string $middleware)
    {
        $this->routes_map[$this->last_request_method][$this->current_used_url]["middleware"] = $middleware;
    }
    public function has_middleware(string $type,string $url)
    {
        $url = $this->prepare_url($url);
        return isset($this->routes_map[$type][$url]["middleware"]);
    }
    public function init_middleware(string $type,string $url,$request_body)
    {
        $url = $this->prepare_url($url);
        $middlewares = explode(",",$this->routes_map[$type][$url]["middleware"]);
        foreach($middlewares as $middleware){
            class_factory::create_instance("middleware\\$middleware",[$request_body]);
        }
    }
    public function get_route(string $type,string $url)
    {
        $url = $this->prepare_url($url);
        return isset($this->routes_map[$type][$url]) ? $this->routes_map[$type][$url][0] : $this->not_found_route();
    }
    public function get_controller(string $route)
    {
        return class_exists("\controllers\\".explode("@",$route)[0]) ? explode("@",$route)[0] : $this->not_found_route();
    }
    public function get_method($controller,string $route)
    {
        return method_exists($controller,explode("@",$route)[1]) ? explode("@",$route)[1] : $this->not_found_route();
    }
    public function get_routes_map()
    {
        return $this->routes_map;
    }
    private function set_route(string $type,string $url,string $target_path)
    {
        $url = $this->prepare_url($url);
        $this->current_used_url = $url;
        $this->last_request_method = $type;
        $this->routes_map[$type][$url] = [$target_path];
    }
    private function prepare_url(string $url)
    {
        if(substr($url, -1) != '/') {
            $url .= "/";
        }
        return $url;
    }
    private function not_found_route()
    {
        http_response_code(404);
        exit();
    }
}