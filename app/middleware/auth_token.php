<?php
namespace middleware;
use lib\vendor\message;
use lib\vendor\class_factory;
class auth_token
{
    use message;
    private $headers;
    public function __construct()
    {
        $this->headers = getallheaders();
        $this->isset_auth_token()->handle();
    }
    private function isset_auth_token()
    {
        return isset($this->headers["auth_token"]) ? $this : $this->response(["key"=>"fail","msg"=>"not_found_auth_token"]);
    }
    private function handle()
    {
        return class_factory::create_instance("models\user")->where("auth_token",$this->headers["auth_token"])->is_exist() ? null : $this->response(["key"=>"fail","msg"=>"wrong_token"]);
    }
}