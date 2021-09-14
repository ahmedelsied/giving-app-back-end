<?php
namespace controllers\api\user;
use lib\vendor\input_filter;
use lib\vendor\message;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\class_factory;
class profile_controller
{
    use input_filter,message,sessionmanger,helper;
    private $params;
    private $headers;
    private $user_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->headers = getallheaders();
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function update_full_name()
    {
        class_factory::create_instance("validation\user\profile\update_full_name_validation",[$this->params])->validate();
        $this->user_model->full_name = $this->filter_string($this->params["full_name"]);
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->save();
        $this->response(["key"=>"success","msg"=>"full_name_updated_successfully"]);
    }
    public function update_password()
    {
        class_factory::create_instance("validation\user\profile\update_password_validation",[$this->params,$this->user_model])->validate();
        $this->user_model->password = $this->hash($this->params["new_password"]);
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->save();
        $this->response(["key"=>"success","msg"=>"password_updated_successfully"]);
    }
    public function update_profile_img()
    {
        class_factory::create_instance("validation\user\profile\update_profile_img_validation",[$this->headers["user_id"]])->validate();
        $profile_img = $this->user_model->where("id",$this->headers["user_id"])->get("profile_img")->pluck("profile_img");
        $this->user_model->profile_img = $this->get_session("img_url");
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->save();
        $path = PROFILE_IMGS_PATH.DS.$this->headers["user_id"].DS;
        if (!empty($profile_img) && file_exists($path.$profile_img)) unlink($path.$profile_img);
        $data = $this->create_user_img_url($this->headers["user_id"],$this->user_model->profile_img);
        $this->response(["key"=>"success","msg"=>"profile_img_updated_successfully","new_profile_img"=>$data]);
    }
    public function get_user_img()
    {
        class_factory::create_instance("validation\user\profile\get_user_img_validation",[$this->params])->validate();
        $this->response_with_img($this->get_session("user_img"));
    }
    public function active_phone_number()
    {
        $this->user_model->is_phone_active = true;
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->save();
        $this->response(["key"=>"success","msg"=>"phone_number_updated_successfully"]);
    }
    public function update_phone_number()
    {
        $this->params["user_id"] = $this->headers["user_id"];
        class_factory::create_instance("validation\user\profile\update_phone_number_validation",[$this->params,$this->user_model])->validate();
        $this->user_model->phone_number = $this->params["phone_number"];
        $this->user_model->country_code = $this->params["country_code"];
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->save();
        $this->response(["key"=>"success","msg"=>"phone_number_updated_successfully"]);
    }
    public function delete_account()
    {
        $this->user_model->where(["id","=",$this->headers["user_id"]],["auth_token","=",$this->headers["auth_token"]])->delete();
        $this->response(["key"=>"success","msg"=>"account_deleted_successfully"]);
    }
}