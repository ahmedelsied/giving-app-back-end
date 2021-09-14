<?php
namespace lib\vendor;
trait code_generator{
    private $code;
    private $expire_at;
    protected $code_resend_time;
    private function generate_code()
    {
        $this->load_code_conf();
        $this->code = substr(hash("sha256",uniqid()),0,5);
    }
    private function get_code()
    {
        return $this->code;
    }
    private function expire_at($time)
    {
        $expired = date("Y-m-d h:i") . " + " . $time;
        $this->expire_at = date('Y-m-d h:i', strtotime($expired));
        return $this->expire_at;
    }
    private function load_code_conf()
    {
        require_once APP_PATH . CONFIG . "code.php";
    }
}