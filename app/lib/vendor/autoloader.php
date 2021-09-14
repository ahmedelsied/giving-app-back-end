<?php
namespace lib\vendor;
class autoloader
{
    public static function autoload($className)
    {
        $className = str_replace('\\', '/', $className);
        $className = $className . '.php';
        if(file_exists(APP_PATH . $className)) {
            require APP_PATH.$className;
        }
    }
}
spl_autoload_register(__NAMESPACE__ . '\autoloader::autoload');