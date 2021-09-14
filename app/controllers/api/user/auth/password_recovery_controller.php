<?php
namespace controllers\api\user\auth;
use lib\vendor\message;
use lib\vendor\helper;
use lib\vendor\mailer;
use lib\vendor\class_factory;
use controllers\api\user\auth\services\code_service;
class password_recovery_controller
{
    use message,helper,mailer,code_service;
    private $params;
    private $resend = false;
    private $user_model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function forget_password()
    {
        $forget_password_data = class_factory::create_instance("validation\user\auth\\forget_password_validation",[$this->params,$this->user_model]);
        $forget_password_data->validate();
        $id = $this->user_model->where("email",$this->params["email"])->get("id")->pluck("id");
        $this->check_if_email_is_active($id);
        $this->params["user_id"] = $id;
        $this->recover_process($this->params);
        $this->response(["key"=>"success","msg"=>"recover_code_is_sent_successfully","data"=>["user_id"=>$this->params["user_id"],"email"=>$this->params["email"]]]);
    }
    private function check_if_email_is_active($id)
    {
        $this->user_model->is_email_active($this->params["email"]) ? null : $this->response(["key"=>"fail","msg"=>"need_active","data"=>["id"=>$id]]);
    }
    private function recover_process($params)
    {
        $this->address($params["email"]);
        $this->subject("Recover Code");
        $this->body("Your recover code is : ".$this->code_service($params["user_id"],$this->resend));
        $this->send_mail();
    }
    public function resend_recover_code()
    {
        $user_model = class_factory::create_instance("models\user");
        $resend_recover_code_validation = class_factory::create_instance("validation\user\auth\\resend_recover_code_validation",[$this->params,$user_model]);
        $resend_recover_code_validation->validate();
        $this->resend = true;
        $this->recover_process($this->params);
        $this->response(["key"=>"success","msg"=>"recover_code_is_sent_successfully"]);
    }
    public function create_new_password()
    {
        $user_model = class_factory::create_instance("models\user");
        $new_password_validation = class_factory::create_instance("validation\user\auth\\new_password_validation",[$this->params,$user_model]);
        $new_password_validation->validate();
        $user_model->password = $this->hash($this->params["password"]);
        $user_model->auth_token = md5(uniqid(rand(), true));
        $user_model->where("id",$this->params["user_id"])->save();
        $user_data = $user_model->where("id",$this->params["user_id"])->get("id,full_name,email,auth_token")->data[0];
        $this->response(["key"=>"success","msg"=>"password_updated_successfully","data"=>$user_data]);
    }
    public function check_recovery_code()
    {
        $code_model = class_factory::create_instance("models\code");
        $code = class_factory::create_instance("validation\user\auth\code_recover_validation",[$this->params,$code_model]);
        $code->validate();
        $code_model->expire_date = $this->set_expired();
        $code_model->where("user_id",$this->params["user_id"])->save();
        $user_model = class_factory::create_instance("models\user");
        $user_model->set_token($this->params["user_id"]);
        $user_data = $user_model->where("id",$this->params["user_id"])->get("id,auth_token")->data[0];
        $this->response(["key"=>"success","msg"=>"code_is_right","data"=>$user_data]);
    }
}