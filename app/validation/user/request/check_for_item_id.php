<?php
namespace validation\user\request;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class check_for_item_id implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_item_id();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["item_id"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_item_id()
    {
        return $this->num($this->params["item_id"]) ? null : $this->response(["key"=>"fail","msg"=>"invalid_item_id"]);
    }
}