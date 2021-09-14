<?php
namespace controllers\api\user\auth\services;
use lib\vendor\code_generator;
use lib\vendor\class_factory;
trait code_service
{
    use code_generator;
    private $user_id;
    private $code_model;
    private function code_service($user_id,$resend = false)
    {
        $this->resend = $resend;
        return $this->set_user_id($user_id)->set_code_model()->code_generation()->prepare_data_model()->save_code()->return_with_code();
    }
    private function set_code_model()
    {
        $this->code_model = class_factory::create_instance("models\code");
        return $this;
    }
    private function code_generation()
    {
        $this->generate_code();
        return $this;
    }
    private function set_expired()
    {
        return $this->expire_at("-1 seconds");
    }
    private function prepare_data_model()
    {
        $this->code_model->user_id = $this->user_id;
        $this->code_model->code = $this->get_code();
        $this->code_model->expire_date = $this->expire_at("5 minutes");
        return $this;
    }
    private function save_code()
    {
        if($this->resend){
            $this->code_model->where(["user_id","=",$this->code_model->user_id])->save();
        }else{
            $this->code_model->save();
        }
        return $this;
    }
    private function return_with_code()
    {
        return $this->get_code();
    }
    private function set_user_id($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }
}