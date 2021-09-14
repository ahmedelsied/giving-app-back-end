<?php
namespace lib\vendor;
trait sessionmanger
{
    private $session_hash_name_string = '_this_is_hard_hash_';
    public static function start()
    {
        session_start();
    }
    public function get_session($name)
    {
        return $this->is_set_session($name) ? $_SESSION[$name.sha1(md5($this->session_hash_name_string))] : null;
    }
    public function is_set_session($session)
    {
        if(isset($_SESSION[$session.sha1(md5($this->session_hash_name_string))])){
            return true;
        }else{
            return false;
        }
    }
    public function set_session($name,$value)
    {
        session_regenerate_id(true);
        $_SESSION[$name.sha1(md5($this->session_hash_name_string))] = $value;
        return $_SESSION[$name.sha1(md5($this->session_hash_name_string))];
    }
    public function unset_session($name)
    {
        session_regenerate_id(true);
        $_SESSION[$name.sha1(md5($this->session_hash_name_string))] = '';
        unset($_SESSION[$name.sha1(md5($this->session_hash_name_string))]);
    }
    public function finish_session()
    {
        session_destroy();
        session_unset();
    }
    public function current_user()
    {
        return $this->get_session('permission');
    }
}