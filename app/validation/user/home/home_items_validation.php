<?php
namespace validation\user\home;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class home_items_validation implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_page();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["page"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_page()
    {
        return $this->num($this->params["page"]) ? null : $this->response(["key"=>"fail","msg"=>"invalid_page_number"]);
    }
}