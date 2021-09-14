<?php
namespace validation\user\profile;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\sessionmanger;
class get_user_img_validation implements validation_interface
{
    use validator,message,sessionmanger;
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
        return $this->params_exist(["user_id","user_img"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_user_id()
    {
        return $this->num($this->params["user_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_item_id"]);
    }
    private function is_exist_img()
    {
        return !empty($this->params["user_img"]) && file_exists(PROFILE_IMGS_PATH.DS.$this->params["user_id"].DS.$this->params["user_img"]) ? $this->set_session("user_img",PROFILE_IMGS_PATH.DS.$this->params["user_id"].DS.$this->params["user_img"]) : $this->set_session("user_img",PROFILE_IMGS_PATH.DS."default.png");
    }
}