<?php
namespace middleware;
use lib\vendor\message;
use lib\vendor\class_factory;
class is_phone_active
{
    use message;
    private $headers;
    public function __construct()
    {
        $this->headers = getallheaders();
        $this->isset_headers()->handle();
    }
    private function isset_headers()
    {
        return (isset($this->headers["auth_token"]) && isset($this->headers["user_id"])) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_headers"]);
    }
    private function handle()
    {
        return class_factory::create_instance("models\user")->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]],["is_phone_active","=",ACTIVE_PHONE])->is_exist() ? null : $this->response(["key"=>"fail","msg"=>"auth_error"]);
    }
}