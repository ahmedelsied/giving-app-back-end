<?php
namespace validation\user\item;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class delete_items_validation implements validation_interface
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
        if(!$this->num($this->params["item_id"])){
            $this->response(["key"=>"fail","msg"=>"parameters_error"]);
        }
    }
}