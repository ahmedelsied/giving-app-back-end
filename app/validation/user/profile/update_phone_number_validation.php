<?php
namespace validation\user\profile;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class update_phone_number_validation implements validation_interface
{
    use validator,message;
    private $params,$user_model;
    public function __construct($params,$user_model)
    {
        $this->set_params($params);
        $this->set_user_model($user_model);
    }
    public function validate() : void
    {
        $this->check_params()->validate_phone_number()->check_if_phone_exist()->validate_country_code();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["phone_number","country_code"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_phone_number()
    {
        return ($this->num($this->params["phone_number"]) && $this->gt($this->params["phone_number"],6) && $this->lt($this->params["phone_number"],16)) ? $this : $this->response(["key"=>"fail","msg"=>"phone_number_wrong"]);
    }
    private function validate_country_code()
    {
        return (!$this->num($this->params["country_code"]) || $this->gt($this->params["country_code"],4)) ? $this->response(["key"=>"fail","msg"=>"invalid_country_code"]) : null;
    }
    private function check_if_phone_exist()
    {
        return $this->user_model->where(["id","!=",$this->params["user_id"]],["phone_number","=",$this->params["phone_number"]])->is_exist() ? $this->response(["key"=>"fail","msg"=>"phone_number_exist"]) : $this;
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
}