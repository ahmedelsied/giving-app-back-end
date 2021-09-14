<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\sessionmanger;
class signup_with_huawei_validation implements validation_interface
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
        $this->check_params()->validate_full_name()->validate_union_id()->check_if_union_id_exist();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["full_name","union_id"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_full_name()
    {
        return ($this->alpha($this->params["full_name"]) && $this->gt($this->params["full_name"],4) && $this->lt($this->params["full_name"],31)) ? $this : $this->response(["key"=>"fail","msg"=>"full_name_error"]);
    }
    private function validate_union_id()
    {
        return $this->alphanum($this->params["union_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"union_id_invalid"]);
    }
    private function check_if_union_id_exist()
    {
        $this->user_model->where("union_id",$this->params["union_id"])->is_exist() ? $this->response(["key"=>"fail","msg"=>"union_id_exist"]) : true;
    }
    private function set_user_model($user_model)
    {
        $this->user_model = $user_model;
    }
}