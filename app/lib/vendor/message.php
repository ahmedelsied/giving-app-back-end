<?php
namespace lib\vendor;
trait message{
    protected function response(array $response)
    {
        echo stripslashes(json_encode($response,JSON_FORCE_OBJECT));
        exit();
    }
    protected function response_without_force_object(array $response)
    {
        echo stripslashes(json_encode($response,JSON_UNESCAPED_UNICODE));
        exit();
    }
    protected function response_with_img($url)
    {
        header('Content-Type:image/jpeg');
        header('Content-Length: ' . filesize($url));
        readfile($url);
        exit();
    }
}