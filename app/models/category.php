<?php
namespace models;
class category extends model
{
    protected static $table_name = 'category';
    public static $table_schema = array(
        'id'            => '',
        'name'          => ''
    );
    protected static $primary_key = 'id';
    public function get_categories()
    {
        return $this->build_query("SELECT * FROM category_view",\PDO::FETCH_ASSOC);
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