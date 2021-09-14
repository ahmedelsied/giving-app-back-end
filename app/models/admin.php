<?php
namespace models;
class admin extends model
{
    protected static $table_name = 'admin';
    public static $table_schema = array(
        'id'            => '',
        'full_name'     => '',
        'user_name'     => '',
        'password'      => '',
        'created_at'    => ''
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
}