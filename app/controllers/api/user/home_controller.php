<?php
namespace controllers\api\user;
use lib\vendor\helper;
use lib\vendor\message;
use lib\vendor\sessionmanger;
use lib\vendor\class_factory;
class home_controller
{
    use helper,message,sessionmanger;
    private $params;
    private $data;
    private $headers;
    private $item_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->headers = getallheaders();
        $this->item_model = class_factory::create_instance("models\item");
    }
    public function home_items()
    {
        class_factory::create_instance("validation\user\home\home_items_validation",[$this->params])->validate();
        $this->data = $this->item_model->home_items($this->headers["user_id"],$this->params["page"]);
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data]);
    }
    public function search()
    {
        class_factory::create_instance("validation\user\home\home_search_validation",[$this->params])->validate();
        $this->data = $this->item_model->search($this->headers["user_id"],$this->params);
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data]);
    }
    public function filter()
    {
        class_factory::create_instance("validation\user\home\home_filter_validation",[$this->params])->validate();
        $this->data = $this->item_model->filter($this->headers["user_id"],$this->params);
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data]);
    }
    private function get_items_imgs()
    {
        for($i=0;$i<count($this->data);$i++){
            $this->data[$i]["item_img"] = $this->create_item_img_url($this->data[$i]["user_id"],$this->data[$i]["item_img"]);
        }
    }
}