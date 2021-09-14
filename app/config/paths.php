<?php

// PATHS
define('LANG_PATH', realpath(dirname(__FILE__)) . DS .'..' . DS .'..' . DS . 'langs' . DS);
define('APP_PATH', realpath(dirname(__FILE__)) . DS .'..' . DS );
define('TEMPENG' , 'templates' . DS);
define('CONTROLLERS' , 'controllers' . DS);
define('MODELS' , 'models' . DS);
define('VIEWS' , 'views' . DS);
define("STORAGE_PATH",APP_PATH."storage".DS);
if(isset($_SERVER['SERVER_NAME'])){
    define('DOMAIN','https://'.$_SERVER['SERVER_NAME']."/");
    define("ITEM_IMGS_URL",DOMAIN."api/user/item/get-item-img?");
    define("PROFILE_IMGS_URL",DOMAIN."api/user/profile/get-user-img?");
}
define("ITEM_IMGS_PATH",STORAGE_PATH."item_imgs");
define("PROFILE_IMGS_PATH",STORAGE_PATH."users_profile_imgs");
define('CONFIG' , 'config' . DS);