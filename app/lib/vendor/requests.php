<?php
namespace lib\vendor;
class requests
{
    private $dynamic_props = [];
    public function __construct()
    {
        $this->handle_request_params();
    }    
    public function __set($prop,$value){
        $this->dynamic_props[$prop] = $value;
    }
    public function __get($prop){
        return $this->dynamic_props[$prop];
    }
    private function handle_request_params()
    {
        $this->method = strtolower($_SERVER["REQUEST_METHOD"]);
        $data = strtolower($this->method) . "_data";
        $this->uri = strtolower(strtok($_SERVER["REQUEST_URI"], '?'));
        if(!method_exists($this, $data)){
            echo "wrong request";
            exit();
        }
        $this->body = $this->$data();
    }
    private function post_data()
    {
        return $_POST;
    }
    private function get_data()
    {
        return $_GET;
    }
    private function put_data()
    {
        parse_str(file_get_contents("php://input"),$data);
        return $data;
    }
    private function delete_data()
    {
        return null;
    }
}