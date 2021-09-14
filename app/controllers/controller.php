<?php
namespace controllers;
class controller
{
    public function view($view)
    {
        require_once APP_PATH . "views". DS . $view . '.php';
    }
}