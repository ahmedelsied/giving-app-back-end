<?php
namespace middleware;
use lib\vendor\message;
use lib\vendor\class_factory;
class is_exceed_request_limit
{
    use message;
    private $headers;
    public function __construct()
    {
        $this->headers = getallheaders();
        $this->handle();
    }
    private function handle()
    {
        return class_factory::create_instance("models\item")->where(["applicant_id","=",$this->headers["user_id"]],["MONTH(request_date)","=",date("m")],["YEAR(request_date)","=",date("Y")])->row_count() >= USER_REQUESTS_LIMIT ? $this->response(["key"=>"fail","msg"=>"you_have_exceed_the_request_limit"]) : null;
    }
}