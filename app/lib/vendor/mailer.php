<?php
namespace lib\vendor;
use lib\vendor\mailer\PHPMailer;
trait mailer{
    private $address;
    private $subject;
    private $body;
    private $alt_body;
    private function send_mail()
    {
        $this->load_mail_conf();
        return $this->handle_mail();
    }
    private function address($address)
    {
        $this->address = $address;
    }
    private function subject($subject)
    {
        $this->subject = $subject;
    }
    private function body($body)
    {
        if(!empty($this->body)) {$this->body .= $body;return;};
        $this->body = $body;
    }
    private function alt_body($alt_body)
    {
        $this->alt_body = $alt_body;
    }
    private function load_mail_conf()
    {
        require_once APP_PATH.CONFIG."mail.php";
    }
    private function handle_mail()
    {
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            // $mail->SMTPDebug  = 4;
            $mail->Host       = HOST;
            $mail->Port       = PORT;
            $mail->SMTPAuth   = true;
            $mail->Username   = SENDER;
            $mail->Password   = PASS;
            $mail->SMTPSecure = "ssl";

            // Content
            $mail->isHTML(true);
            $mail->From = SENDER;
            $mail->FromName = 'Giveaway';
            $mail->addAddress($this->address);
            $mail->addReplyTo('no-reply-'.SENDER);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;
            $mail->AltBody = $this->alt_body;
            if($mail->send()){
                return true;
            }else{
                return false;
            }
        } catch (\Exception $e) {
            echo json_encode(["key"=>"fail","msg"=>"somthing_is_wrong"]);
            exit();
        }
    }
}