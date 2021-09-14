<?php
namespace validation\user\profile;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class update_full_name_validation implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_full_name();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["full_name"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_full_name()
    {
        ($this->alpha($this->params["full_name"]) && $this->gt($this->params["full_name"],4) && $this->lt($this->params["full_name"],25)) ? null : $this->response(["key"=>"fail","msg"=>"full_name_error"]);
    }
}