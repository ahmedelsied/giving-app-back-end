<?php
namespace controllers\api\user\auth;
use lib\vendor\message;
use lib\vendor\helper;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
class login_controller
{
    use message,helper,input_filter;
    private $params;
    private $user_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function login()
    {
        class_factory::create_instance("validation\user\auth\login_validation",[$this->params,$this->user_model])->validate();
        $user_data = $this->user_model->login($this->filter_string($this->params["email"]),$this->hash($this->params['password']));
        if(!empty($user_data)){
            $this->check_if_email_is_active();
            $user_data["auth_token"] = $this->user_model->update_token($user_data["id"]);
            $user_data["profile_img"] = $this->create_user_img_url($user_data["id"],$user_data["profile_img"]);
            $this->response(["key"=>"success","msg"=>"logged_in_successfully","data"=>$user_data]);
        }else{
            $this->response(["key"=>"fail","msg"=>"email_or_password_is_wrong"]);
        }
    }
    public function login_with_huawei()
    {
        class_factory::create_instance("validation\user\auth\login_with_huawei_validation",[$this->params])->validate();
        $user_data = $this->user_model->login_with_huawei($this->filter_string($this->params["union_id"]));
        if(!empty($user_data)){
            $user_data["auth_token"] = $this->user_model->update_token($user_data["id"]);
            $user_data["profile_img"] = $this->create_user_img_url($user_data["id"],$user_data["profile_img"]);
            $this->response(["key"=>"success","msg"=>"logged_in_successfully","data"=>$user_data]);
        }else{
            $this->response(["key"=>"fail","msg"=>"union_id_is_wrong"]);
        }
    }
    private function check_if_email_is_active()
    {
        $this->user_model->is_email_active($this->params["email"]) ? null : $this->response(["key"=>"fail","msg"=>"need_active","data"=>["id"=>$this->user_model->where("email",$this->params["email"])->get("id")->pluck("id")]]);
    }
}