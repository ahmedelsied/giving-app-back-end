<?php
namespace lib\vendor;
class class_factory 
{
    public static function create_instance($class_name,array $class_constructor_argument = [])
    {
        $class = new \ReflectionClass("\\".$class_name);
        return $class->newInstanceArgs($class_constructor_argument);
    }
}