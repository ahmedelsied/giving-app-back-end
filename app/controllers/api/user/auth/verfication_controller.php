<?php
namespace controllers\api\user\auth;
use lib\vendor\message;
use lib\vendor\mailer;
use lib\vendor\class_factory;
use controllers\api\user\auth\services\code_service;
class verfication_controller
{
    use message,code_service,mailer;
    private $params;
    private $resend = false;
    private $user_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function active_code()
    {
        $code_model = class_factory::create_instance("models\code");
        $code = class_factory::create_instance("validation\user\auth\code_activation_validation",[$this->params,$code_model]);
        $code->validate();
        $code_model->expire_date = $this->set_expired();
        $code_model->where("user_id",$this->params["user_id"])->save();
        $this->user_model->set_token($this->params["user_id"]);
        $user_data = $this->user_model->where("id",$this->params["user_id"])->limit(1)->get("id,full_name,email,auth_token")->data[0];
        $this->response(["key"=>"success","msg"=>"account_activated","data"=>$user_data]);
    }
    public function resend_active_code()
    {
        $code = class_factory::create_instance("validation\user\auth\\resend_active_code_validation",[$this->params]);
        $code->validate();
        $this->resend = true;
        $this->active_process($this->params);
        $this->response(["key"=>"success","msg"=>"code_is_sent_successfully","data"=>["user_id"=>$this->params["user_id"]]]);
    }
    private function active_process($params)
    {
        $this->address($params["email"]);
        $this->subject("Code Activation");
        $this->body("Your code activation is : ".$this->code_service($params["user_id"],$this->resend));
        $this->send_mail();
    }
}