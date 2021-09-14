<?php
namespace validation\user\item;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\class_factory;
use lib\vendor\message;
use lib\vendor\singly_file_upload;
class update_item_img_validation implements validation_interface
{
    use validator,message,singly_file_upload;
    private $params;
    private $user_id;
    public function __construct($params,$user_id)
    {
        $this->set_params($params);
        $this->user_id = $user_id;
    }
    public function validate() : void
    {
        $this->check_params()->validate_item_id()->validate_item_img();
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
        return $this->num($this->params["item_id"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_item_id"]);
    }
    private function validate_item_img()
    {
        $this->allowed_extension = ["png","jpg","jpeg"];
        $this->max_size = MAX_FILE_SIZE;
        return $this->file_upload("item_img",ITEM_IMGS_PATH.DS.$this->user_id) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_file"]);
    }
}