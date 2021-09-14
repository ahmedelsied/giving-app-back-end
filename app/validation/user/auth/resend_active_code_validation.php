<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class resend_active_code_validation implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_email()->validate_id();
    }
    private function check_params()
    {
        return $this->params_exist(["user_id","email"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_email()
    {
        return $this->email($this->params["email"]) ? $this : $this->response(["key"=>"fail","msg"=>"email_is_wrong"]);
    }
    private function validate_id()
    {
        return $this->num($this->params["user_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"id_is_ivalid"]);
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
}