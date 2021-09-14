<?php
namespace lib\database;
use PDO;
class db_connection
{
    private $dsn 	= "mysql:host=".DATABASE_HOST_NAME.";dbname=".DATABASE_DB_NAME;
    private $user	= DATABASE_USER_NAME;
    private $pass	= DATABASE_PASSWORD;
    private $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    );
    public function __construct()
    {
        try{
            global $con;
            $con = new PDO($this->dsn,$this->user,$this->pass,$this->option);
            $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            echo "Failed TO Connected :".$e->getMessage();
        }
    }
}