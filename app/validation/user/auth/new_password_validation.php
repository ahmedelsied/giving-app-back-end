<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class new_password_validation implements validation_interface
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
        $this->check_params()->check_token()->validate_password();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
    private function check_params()
    {
        return $this->params_exist(["user_id","password","auth_token"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function check_token()
    {
        return $this->user_model->check_token($this->params["user_id"],$this->params["auth_token"]) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_auth_token"]);
    }
    private function validate_password()
    {
        return $this->req($this->params["password"]) ? null : $this->response(["key"=>"fail","msg"=>"password_is_empty"]);
    }
}