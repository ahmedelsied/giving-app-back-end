<?php
namespace controllers\api\user\will_delete;
use lib\vendor\class_factory;
class database_actions
{
    private $user_model;
    public function __construct()
    {
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function delete_all()
    {
        $this->user_model->delete_all();
    }
}