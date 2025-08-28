<?php

 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require_once "../PHPMailer-FE_v4.11/_lib/phpmailer-fe.php";

 class EmailHelper
 {
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        //SMTP settings
        $this->mailer->isSMTP();
        $this->mailer->Host = "smtp.gmail.com";
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = "kelseyoben@gmail.com";
        $this->mailer->Password = "job_portal";
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->setFrom("kelseyoben@gmail.com", "Job Portal");
    }
    //Send email
    public function sendEmail($to, $subject, $body)
    {
        try
        {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            //$this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->send();
            return true;
        }
        catch(Exception $e)
        {
            return "Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
 }

?>