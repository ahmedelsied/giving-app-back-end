<?php
namespace lib\vendor;
trait helper
{
    private function redirect($path = null)
    {
        session_write_close();
        $finalURL = (empty($path) && isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $path;
        header('Location: ' . $finalURL);
        exit();
    }
    private function hash($pass)
    {
        return sha1(md5($pass).HARD_HASH);
    }
    public function create_item_img_url($user_id,$img_name)
    {
        return ITEM_IMGS_URL."user_id=".$user_id."&item_img=".$img_name;
    }
    public function create_user_img_url($user_id,$img_name)
    {
        return PROFILE_IMGS_URL."user_id=".$user_id."&user_img=".$img_name;
    }
}