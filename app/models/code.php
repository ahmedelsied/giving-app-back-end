<?php
namespace models;
class code extends model
{
    protected static $table_name = 'code';
    public static $table_schema = array(
        'id'            => '',
        'code'          => '',
        'user_id'       => '',
        'expire_date'   => ''
    );
    protected static $primary_key = 'id';

    public function __set($prop,$value)
    {
        self::$table_schema[$prop] = $value;
    }
    public function __get($prop)
    {
        return self::$table_schema[$prop];
    }
    public function is_active_code($user_id,$code)
    {
        return $this->where(["user_id","=",$user_id],["code","=",$code],["expire_date",">=",date("Y-m-d h:i:s")])->is_exist();
    }
}