<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\sessionmanger;
class signup_validation implements validation_interface
{
    use validator,message,sessionmanger;
    private $params;
    private $user_model;
    public function __construct($params,$user_model)
    {
        $this->set_params($params);
        $this->set_user_model($user_model);
    }
    public function validate() : void
    {
        $this->check_params()->validate_full_name()->validate_email()->validate_phone()->validate_password()->validate_country_code()->check_if_phone_exist()->check_if_email_exist();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["full_name","email","password","country_code","phone_number"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_full_name()
    {
        return ($this->alpha($this->params["full_name"]) && $this->gt($this->params["full_name"],4) && $this->lt($this->params["full_name"],31)) ? $this : $this->response(["key"=>"fail","msg"=>"full_name_error"]);
    }
    private function validate_email()
    {
        return ($this->email($this->params["email"]) && $this->gt($this->params["email"],4) && $this->lt($this->params["email"],31)) ? $this : $this->response(["key"=>"fail","msg"=>"email_wrong"]);
    }
    private function validate_phone()
    {
        return ($this->num($this->params["phone_number"]) && $this->gt($this->params["phone_number"],6) && $this->lt($this->params["phone_number"],16)) ? $this : $this->response(["key"=>"fail","msg"=>"phone_number_wrong"]);
    }
    private function validate_password()
    {
        return $this->req($this->params["password"]) ? $this : $this->response(["key"=>"fail","msg"=>"password_empty"]);
    }
    private function validate_country_code()
    {
        return (!$this->num($this->params["country_code"]) || $this->gt($this->params["country_code"],4)) ? $this->response(["key"=>"fail","msg"=>"invalid_country_code"]) : $this;
    }
    private function check_if_phone_exist()
    {
        return $this->user_model->is_phone_exist($this->params["phone_number"]) ? $this->response(["key"=>"fail","msg"=>"phone_exist"]) : $this;
    }
    private function check_if_email_exist()
    {
        $this->user_model->is_email_exist($this->params["email"]) ? $this->check_if_active() : true;
    }
    private function check_if_active()
    {
        $this->user_model->where(["email","=",$this->params["email"]],["status","=",ACTIVE_USER])->is_exist() ? $this->response(["key"=>"fail","msg"=>"email_exist"]) : $this->set_need_active();
    }
    private function set_need_active()
    {
        $this->set_session("need_active",true);
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
}