<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class code_activation_validation implements validation_interface
{
    use validator,message;
    private $params;
    private $code_model;
    public function __construct($params,$code_model)
    {
        $this->set_params($params);
        $this->set_code_model($code_model);
    }
    public function validate() : void
    {
        $this->check_params()->is_expired();
    }
    private function check_params()
    {
        return ($this->params_exist(["user_id","code"],$this->params) && $this->num($this->params["user_id"])) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function is_expired()
    {
        $this->code_model->is_active_code($this->params["user_id"],$this->params["code"]) ? true : $this->response(["key"=>"fail","msg"=>"code_is_wrong_or_expired"]);
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function set_code_model($code_model)
    {
        $this->code_model = $code_model;
    }
}