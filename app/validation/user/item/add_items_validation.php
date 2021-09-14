<?php
namespace validation\user\item;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\class_factory;
use lib\vendor\message;
use lib\vendor\singly_file_upload;
class add_items_validation implements validation_interface
{
    use validator,message,singly_file_upload;
    private $params;
    private $category_model;
    private $user_id;
    public function __construct($params,$user_id)
    {
        $this->set_params($params);
        $this->set_category_model();
        $this->user_id = $user_id;
    }
    public function validate() : void
    {
        $this->check_params()->validate_item_title()->validate_category_id()->validate_description()->validate_lat()->validate_lng()->validate_country()->validate_city()->validate_item_img();
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function set_category_model()
    {
        $this->category_model = class_factory::create_instance("models\category");
    }
    private function check_params()
    {
        return $this->params_exist(["item_title","category_id","description","lat","lng","country","city"],$this->params) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function validate_item_title()
    {
        return ($this->alphanum($this->params["item_title"]) && $this->lt($this->params["item_title"],91)) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_item_title"]);
    }
    private function validate_category_id()
    {
        return ($this->num($this->params["category_id"]) && $this->is_category_id_exist()) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_category_id"]);
    }
    private function is_category_id_exist()
    {
        return $this->category_model->where("id",$this->params["category_id"])->is_exist();
    }
    private function validate_description()
    {
        return strip_tags($this->params["description"]) == $this->params["description"]  ? $this : $this->response(["key"=>"fail","msg"=>"invalid_description"]);
    }
    private function validate_item_img()
    {
        $this->allowed_extension = ["png","jpg","jpeg"];
        $this->max_size = MAX_FILE_SIZE;
        return $this->file_upload("item_img",ITEM_IMGS_PATH.DS.$this->user_id) ? null : $this->response(["key"=>"fail","msg"=>"invalid_file"]);
    }
    private function validate_lat()
    {
        return $this->coords($this->params["lat"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_lat"]);
    }
    private function validate_lng()
    {
        return $this->coords($this->params["lng"]) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_lng"]);
    }
    private function validate_country()
    {
        return ($this->alpha($this->params["country"]) && $this->lt($this->params["country"],61)) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_country"]);
    }
    private function validate_city()
    {
        return ($this->alpha($this->params["city"]) && $this->lt($this->params["city"],31)) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_city"]);
    }
}