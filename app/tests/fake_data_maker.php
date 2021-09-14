<?php
namespace tests;
require_once "../lib/vendor/autoload.php";
(!defined('DS')) ? define('DS', DIRECTORY_SEPARATOR) : null;
require_once "../init.php";
require_once "../lib/vendor/autoloader.php";
use lib\vendor\class_factory;
use tests\faker_abstract;
class fake_data_maker
{
    private $faker;
    public function __construct()
    {
        $connect = new \lib\database\db_connection;
        $this->faker = \Faker\Factory::create();
    }
    public function fake_categories()
    {
        echo "enter number of data : ";
        fscanf(STDIN,"%s\n",$count);
        $category_model = class_factory::create_instance("models\category");
        for ($i = 0; $i < $count; $i++) {
            $category_model->name = $this->faker->name . "\n";
            $category_model->save();
        }
    }
    public function fake_items()
    {
        echo "enter number of data : ";
        fscanf(STDIN,"%s\n",$count);
        $item_model = class_factory::create_instance("models\item");
        for ($i = 0; $i < $count; $i++) {
            $item_model->user_id = 15;
            $item_model->item_title = $this->faker->word;
            $item_model->category_id = 6;
            $item_model->description = $this->faker->sentence();
            $item_model->item_img = $this->faker->url;
            $item_model->coords = "GeomFromText('POINT(45.1234 123.4567)')";
            $item_model->country =  $this->faker->country;
            $item_model->city =  $this->faker->city;
            $item_model->save();
        }
    }
}
$fake = new fake_data_maker;
$methods = get_class_methods($fake);
echo "enter method name : \nall methods :-\n";
echo "---------------------\n";
for($i=0;$i<count($methods);$i++){
    if($i==0){
        continue;
    }
    echo $methods[$i]."\n";
}
echo "---------------------\n";
fscanf(STDIN,"%s\n",$method);
$fake->$method();