<?php
namespace controllers\_public;
use controllers\controller;
class policy_controller extends controller
{
    private $params;
    public function __construct($params)
    {
        $this->params = $params;
        
    }
    public function index()
    {
        if(isset($this->params["lang"]) && $this->params["lang"] == "en"){
            $this->view("policy_view");
        }else{
            $this->view("policy_ar_view");
        }
    }
}