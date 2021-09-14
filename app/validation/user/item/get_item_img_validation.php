<?php
namespace validation\user\item;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
class get_item_img_validation implements validation_interface
{
    use validator,message;
    private $params;
    private $category_model;
    public function __construct($params)
    {
        $this->set_params($params);
    }
    public function validate() : void
    {
        $this->check_params()->validate_user_id()->is_exist_img();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function check_params()
    {
        return $this->params_exist(["user_id","item_img"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_user_id()
    {
        return $this->num($this->params["user_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_item_id"]);
    }
    private function is_exist_img()
    {
        return file_exists(ITEM_IMGS_PATH.DS.$this->params["user_id"].DS.$this->params["item_img"]) ? null : $this->response(["key"=>"fail","msg"=>"not_exist_img"]);
    }
}