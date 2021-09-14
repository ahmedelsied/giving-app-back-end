<?php
namespace controllers\api\user;
use lib\vendor\message;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\class_factory;
class item_controller
{
    use message,sessionmanger,helper;
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
    public function get_accepted()
    {
        class_factory::create_instance("validation\user\item\get_accepted_items_validation",[$this->params])->validate();
        $this->data = $this->item_model->get_accepted($this->headers['user_id'],$this->params);
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data,"data_count"=>count($this->data)]);
    }
    public function get_pending()
    {
        class_factory::create_instance("validation\user\item\get_pending_items_validation",[$this->params])->validate();
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->item_model->get_pending($this->headers['user_id'],$this->params)]);
    }
    public function add()
    {
        class_factory::create_instance("validation\user\item\add_items_validation",[$this->params,$this->headers["user_id"]])->validate();
        $this->item_model->user_id = $this->headers["user_id"];
        $this->item_model->item_title = $this->params["item_title"];
        $this->item_model->category_id = $this->params["category_id"];
        $this->item_model->description = $this->params["description"];
        $this->item_model->status = ACCEPTED;
        $this->item_model->item_img = $this->get_session("item_img");
        $this->item_model->coords = "GeomFromText('POINT(".$this->params["lat"]." ".$this->params["lng"].")')";
        $this->item_model->country =  $this->params["country"];
        $this->item_model->city =  $this->params["city"];
        $this->item_model->save();
        $this->response(["key"=>"success","msg"=>"added_successfully"]);
    }
    public function update()
    {
        class_factory::create_instance("validation\user\item\update_item_validation",[$this->params])->validate();
        $this->item_model->item_title = $this->params["item_title"];
        $this->item_model->category_id = $this->params["category_id"];
        $this->item_model->description = $this->params["description"];
        $this->item_model->coords = "GeomFromText('POINT(45.1234 123.4567)')";
        $this->item_model->country =  $this->params["country"];
        $this->item_model->city =  $this->params["city"];
        $this->item_model->where(["id","=",$this->params["id"]],["user_id","=",$this->headers["user_id"]])->save();
        $this->response(["key"=>"success","msg"=>"updated_successfully"]);
    }
    public function get_item_img()
    {
        class_factory::create_instance("validation\user\item\get_item_img_validation",[$this->params])->validate();
        $this->response_with_img(ITEM_IMGS_PATH.DS.$this->params["user_id"].DS.$this->params["item_img"]);
    }
    public function item()
    {
        class_factory::create_instance("validation\user\item\get_item_details_validation",[$this->params])->validate();
        $this->data = $this->item_model->item_profile($this->params["item_id"]);
        $this->data[0]["item_img"] = $this->create_item_img_url($this->data[0]["user_id"],$this->data[0]["item_img"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data]);
    }
    public function update_item_img()
    {
        class_factory::create_instance("validation\user\item\update_item_img_validation",[$this->params,$this->headers["user_id"]])->validate();
        $item_img = $this->item_model->where("id",$this->params["item_id"])->get("item_img")->pluck("item_img");
        $this->item_model->item_img = $this->get_session("item_img");
        $this->item_model->where(["id","=",$this->params["item_id"]],["user_id","=",$this->headers["user_id"]])->save();
        $path = ITEM_IMGS_PATH.DS.$this->headers["user_id"].DS;
        if (!empty($item_img) && file_exists($path.$item_img)) unlink($path.$item_img);
        $this->response_without_force_object(["key"=>"success","msg"=>"item_img_has_been_updated"]);
    }
    public function get_categories()
    {
        $categories_model = class_factory::create_instance("models\category");
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$categories_model->get_categories()]);
    }
    public function delete()
    {
        class_factory::create_instance("validation\user\item\delete_items_validation",[$this->headers])->validate();
        $this->item_model->where("id",$this->headers["item_id"])->delete();
        $this->response_without_force_object(["key"=>"success","msg"=>"item_has_been_deleted"]);
    }
    private function get_items_imgs()
    {
        for($i=0;$i<count($this->data);$i++){
            $this->data[$i]["item_img"] = $this->create_item_img_url($this->headers["user_id"],$this->data[$i]["item_img"]);
        }
    }
}