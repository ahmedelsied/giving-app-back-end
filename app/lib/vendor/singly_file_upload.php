<?php
namespace lib\vendor;
use lib\vendor\sessionmanger;
trait singly_file_upload
{
    use sessionmanger;
    private $inpt_name;
    private $file;
    private $src;
    private $max_size;
    private $allowed_extension;
    public function file_upload($inpt_name,$src){
        global $con;
        $this->inpt_name = $inpt_name;
        return $this->isset_file_name()->set_file()->set_src($src)->check_for_errors()->set_file_name()->set_file_extension()->check_allowed_extension()->check_file_size()->upload_file();
    }
    private function isset_file_name()
    {

        return isset($_FILES[$this->inpt_name]) ? $this : $this->response(["key"=>"fail","msg"=>"wrong_parameters"]);
    }
    private function set_file()
    {
        $this->file = $_FILES[$this->inpt_name];
        return $this;
    }
    private function set_src($src)
    {
        $this->src = $src;
        return $this;
    }
    private function check_for_errors()
    {
        return $this->file["error"] == 0 ? $this : $this->response(["key"=>"fail","msg"=>"somthing_is_wrong"]);
    }
    private function set_file_name()
    {
        $this->file["name"] = rand(0,10000).time().'_'.$this->file["name"];
        return $this;
    }
    private function check_allowed_extension()
    {
        return !in_array($this->file["extension"],$this->allowed_extension) ? $this->response(["key"=>"fail","msg"=>"invalid_extension"]) : $this;
    }
    private function set_file_extension(Type $var = null)
    {
        $this->file["extension"] = pathinfo($this->file["name"], PATHINFO_EXTENSION);
        return $this;
    }
    private function check_file_size()
    {
        return $this->file["size"] <= $this->max_size ? $this : $this->response(["key"=>"fail","msg"=>"invalid_file_size"]);
    }
    private function upload_file()
    {
        if(!is_dir($this->src)){
            mkdir($this->src,0777);
        }
        return move_uploaded_file($this->file["tmp_name"],$this->src.DS.$this->file["name"]) ? $this->set_file_name_session() : $this->response(["key"=>"fail","msg"=>"somthing_is_wrong"]);
    }
    private function set_file_name_session()
    {
        $this->set_session($this->inpt_name,$this->file["name"]);
        return true;
    }
}