<?php
namespace validation\user\auth;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class login_with_huawei_validation implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_union_id();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["union_id"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_union_id()
    {
        return $this->alphanum($this->params["union_id"]) ? null : $this->response(["key"=>"fail","msg"=>"union_id_invalid"]);
    }
}