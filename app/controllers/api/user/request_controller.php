<?php
namespace controllers\api\user;
use lib\vendor\message;
use lib\vendor\helper;
use lib\vendor\sessionmanger;
use lib\vendor\class_factory;
class request_controller
{
    use message,helper,sessionmanger;
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
    public function get_all()
    {
        $this->data = $this->item_model->get_user_requests($this->headers['user_id']);
        $this->get_items_imgs();
        $this->response_without_force_object(["key"=>"success","msg"=>"data_has_been_acquired","data"=>$this->data]);
    }
    public function make()
    {
        $this->check_for_item_it();
        if($this->item_model->make_item_requests($this->params["item_id"],$this->headers['user_id'])) $this->response_without_force_object(["key"=>"success","msg"=>"requested_successfully"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"already_requested"]);
    }
    public function delete()
    {
        $this->check_for_item_it();
        if($this->item_model->delete_item_requests($this->params["item_id"],$this->headers['user_id'])) $this->response_without_force_object(["key"=>"success","msg"=>"request_deleted_successfully"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"somthing_wrong"]);
    }
    public function accept()
    {
        $this->check_for_item_it();
        if($this->item_model->accept_item_request($this->params["item_id"],$this->headers['user_id'])) $this->response_without_force_object(["key"=>"success","msg"=>"request_accepted_successfully"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"somthing_wrong"]);
    }
    public function refuse()
    {
        $this->check_for_item_it();
        if($this->item_model->refuse_item_request($this->params["item_id"],$this->headers['user_id']))
        $this->response_without_force_object(["key"=>"success","msg"=>"request_refused_successfully"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"somthing_wrong"]);
    }
    public function delivered()
    {
        $this->check_for_item_it();
        if($this->item_model->delivered($this->params["item_id"],$this->headers['user_id'])) $this->response_without_force_object(["key"=>"success","msg"=>"request_delivered_successfully"]);
        $this->response_without_force_object(["key"=>"success","msg"=>"somthing_wrong"]);
    }
    private function check_for_item_it()
    {
        class_factory::create_instance("validation\user\\request\check_for_item_id",[$this->params])->validate();
    }
    private function get_items_imgs()
    {
        for($i=0;$i<count($this->data[0]);$i++){
            $this->data[0][$i]["item_img"] = $this->create_item_img_url($this->data[0][$i]["user_id"],$this->data[0][$i]["item_img"]);
        }
    }
}