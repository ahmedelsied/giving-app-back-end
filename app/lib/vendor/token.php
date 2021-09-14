<?php
namespace lib\vendor;
trait token{
    private $token;
    private function get_token()
    {
        return $this->token;
    }
    private function destroy_token()
    {
        $this->token = "";
    }
    private function generate_toke()
    {
        return hash("sha256",uniqid());
    }
    public function html_token()
    {
        $this->html = true;
        if(empty($this->token)) $this->set_token();
        return "<input type='hidden' name='hash_token' value='".$this->token."'/>";
    }
}