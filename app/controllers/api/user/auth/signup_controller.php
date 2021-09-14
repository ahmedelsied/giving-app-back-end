<?php
namespace controllers\api\user\auth;
use lib\vendor\message;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\mailer;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use controllers\api\user\auth\services\code_service;
class signup_controller
{
    use message,sessionmanger,helper,mailer,input_filter,code_service;
    private $params;
    private $resend = false;
    private $user_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function signup()
    {
        class_factory::create_instance("validation\user\auth\signup_validation",[$this->params,$this->user_model])->validate();
        if($this->get_session("need_active") == null){
            $this->user_model->full_name = $this->filter_string($this->params["full_name"]);
            $this->user_model->email = $this->filter_string($this->params["email"]);
            $this->user_model->password = $this->hash($this->params["password"]);
            $this->user_model->country_code = $this->filter_string($this->params["country_code"]);
            $this->user_model->phone_number = $this->filter_string($this->params["phone_number"]);
            $this->user_model->status = USER_DISABLED;
            $this->user_model->created_at = date("Y-m-d h:i:s");
            $this->user_model->save();
            $msg = "signup_success";
            $key = "success";
        }else{ 
            $this->resend = true;
            $msg = "need_activate";
            $key = "fail";
        }
        $this->set_session("need_active",null);
        $id = $this->active_process(["email"=>$this->filter_string($this->params["email"]),"user_id"=>$this->user_model->get_id_by_email($this->filter_string($this->params["email"]))]);
        $this->response(["key"=>$key,"msg"=>$msg,"data"=>["user_id"=>$id]]);
    }
    public function sign_up_with_huawei()
    {
        class_factory::create_instance("validation\user\auth\signup_with_huawei_validation",[$this->params,$this->user_model])->validate();
        $this->user_model->full_name = $this->filter_string($this->params["full_name"]);
        $this->user_model->status = ACTIVE_USER;
        $this->user_model->union_id = $this->filter_string($this->params["union_id"]);
        $this->user_model->save();
        $this->response(["key"=>"success","msg"=>"signup_success"]);
    }
    private function active_process($params)
    {
        $this->address($params["email"]);
        $this->subject("Code Activation");
        $this->body("Your code activation is : ".$this->code_service($params["user_id"],$this->resend));
        $this->send_mail();
        return $params["user_id"];
    }
}