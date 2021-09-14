<?php
namespace validation\user\profile;
use validation\validation_interface;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\singly_file_upload;
class update_profile_img_validation implements validation_interface
{
    use validator,message,singly_file_upload;
    private $params;
    private $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    public function validate() : void
    {
        $this->validate_img_url();
    }
    private function validate_img_url()
    {
        $this->allowed_extension = ["png","jpg","jpeg"];
        $this->max_size = MAX_FILE_SIZE;
        return $this->file_upload("img_url",PROFILE_IMGS_PATH.DS.$this->user_id) ? $this : $this->response(["key"=>"fail","msg"=>"invalid_file"]);
    }
}