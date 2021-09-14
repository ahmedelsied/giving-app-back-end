<?php
namespace validation\user\home;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class home_filter_validation implements validation_interface
{
    use validator,message;
    private $params;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_page()->validate_query()->validate_country()->validate_city()->validate_category_id();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["page","country","city","category_id","query"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_page()
    {
        return $this->num($this->params["page"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_page_number"]);
    }
    private function validate_query()
    {
        if(empty($this->params["query"])) return $this;
        return $this->alphanum($this->params["query"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_query"]);
    }
    private function validate_country()
    {
        if(empty($this->params["country"])) return $this;
        return $this->alpha($this->params["country"]) || $this->params["country"] == null ? $this : $this->response(["key"=>"fail","msg"=>"invalid_country"]);
    }
    private function validate_city()
    {
        if(empty($this->params["city"])) return $this;
        return $this->alpha($this->params["city"]) || $this->params["city"] == null ? $this : $this->response(["key"=>"fail","msg"=>"invalid_city"]);
    }
    private function validate_category_id()
    {
        if(empty($this->params["category_id"])) return $this;
        return $this->num($this->params["category_id"]) || $this->params["category_id"] == null ? $this : $this->response(["key"=>"fail","msg"=>"invalid_category_id"]);
    }
}