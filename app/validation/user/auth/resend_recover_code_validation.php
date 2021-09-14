<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class resend_recover_code_validation implements validation_interface
{
    use validator,message;
    private $params;
    private $user_model;
    public function __construct($params,$user_model)
    {
        $this->set_params($params);
        $this->set_user_model($user_model);
    }
    public function validate() : void
    {
        $this->check_params()->validate_email()->validate_id()->is_email_exist();
    }
    private function check_params()
    {
        return $this->params_exist(["user_id","email"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_email()
    {
        return $this->email($this->params["email"]) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_email"]);
    }
    private function validate_id()
    {
        return $this->num($this->params["user_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_id"]);
    }
    private function is_email_exist()
    {
        return $this->user_model->is_email_exist($this->params["email"]) ? $this : $this->response(["key"=>"fail","msg"=>"email_not_exist"]);
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
}