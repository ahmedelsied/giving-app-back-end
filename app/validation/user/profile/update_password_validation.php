<?php
namespace validation\user\profile;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\helper;
class update_password_validation implements validation_interface
{
    use validator,message,helper;
    private $params;
    private $user_model;
    public function __construct($params,$user_model)
    {
        $this->set_params($params);
        $this->set_user_model($user_model);
    }
    public function validate() : void
    {
        $this->check_params()->check_old_password()->validate_new_password();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["old_password","new_password"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function check_old_password()
    {
        return $this->user_model->where("password",$this->hash($this->params["old_password"]))->is_exist() ? $this : $this->response(["key"=>"fail","msg"=>"wrong_old_password"]);
    }
    private function validate_new_password()
    {
        $this->gt($this->params["new_password"],7) ? null : $this->response(["key"=>"fail","msg"=>"invalid_new_password"]);
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
}