<?php
namespace models;
use lib\vendor\token;
class user extends model
{
    use token;
    protected static $table_name = 'user';
    public static $table_schema = array(
        'id'                => '',
        'full_name'         => '',
        'email'             => '',
        'union_id'          => '',
        'password'          => '',
        'profile_img'       => '',
        'country_code'      => '',
        'phone_number'      => '',
        'is_phone_active'   => '',
        'status'            => '',
        'auth_token'        => '',
        'created_at'        => ''
    );
    protected static $primary_key = 'id';
    public function set_token($user_id)
    {
        $this->auth_token = $this->generate_toke();
        $this->status = ACTIVE_USER;
        $this->where("id",$user_id)->save();
    }
    public function check_token($user_id,$token)
    {
        return $this->where("id",$user_id)->get("auth_token")->pluck("auth_token") == $token;
    }
    public function get_id_by_email(string $email)
    {
        return $this->where("email",$email)->get("id")->pluck("id");
    }
    public function update_token($user_id)
    {
        $this->auth_token = $this->generate_toke();
        $this->where("id",$user_id)->save();
        return $this->auth_token;
    }
    public function is_email_exist($email)
    {
        return $this->where("email",$email)->is_exist();
    }
    public function is_phone_exist($phone)
    {
        return $this->where("phone_number",$phone)->is_exist();
    }
    public function is_email_active()
    {
        return $this->where("status",ACTIVE_USER)->is_exist();
    }
    public function login(string $email,string $password)
    {
        $data = $this->where(["email","=",$email],["password","=",$password])->get("id,full_name,email,profile_img,country_code,phone_number,is_phone_active,auth_token")->data;
        return !empty($data) ? $data[0] : [];
    }
    public function login_with_huawei(string $union_id)
    {
        $data = $this->where(["union_id","=",$union_id])->get("id,full_name,union_id,profile_img,country_code,phone_number,is_phone_active,auth_token")->data;
        return !empty($data) ? $data[0] : [];
    }
    public function __set($prop,$value)
    {
        self::$table_schema[$prop] = $value;
    }
    public function __get($prop)
    {
        return self::$table_schema[$prop];
    }
}