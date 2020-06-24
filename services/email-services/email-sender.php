<?php
declare(strict_types=1);

namespace services\email_services;

use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    private $phpMail;
    private $smtpAccount;

    public function __construct(PhpMail $phpMail)
    {
        $this->phpMail = $phpMail;
        $this->smtpAccount = config('smtp.gmail');
    }

    public function send(EmailMessage $emailMessage)
    {

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = $this->smtpAccount['Host'];
            $mail->Port = $this->smtpAccount['Port'];
            $mail->SMTPSecure = $this->smtpAccount['SMTPSecure'];
            $mail->SMTPAutoTLS = $this->smtpAccount['SMTPAutoTLS'];
            $mail->SMTPAuth = true;
            $mail->Timeout = $this->smtpAccount['Timeout'];
            $mail->Username = $this->smtpAccount['Username'];
            $mail->Password = $this->smtpAccount['Password'];
            $mail->setFrom($this->smtpAccount['From']);
            if(!empty(($emailMessage->getAttachment()))){
                $mail->addAttachment($emailMessage->getAttachment());
            }
            foreach ($emailMessage->getAttachmentList() as $attachment)
            {
                $mail->addAttachment($attachment);
            }
            $mail->addAddress($emailMessage->getEmailTo()->getEmail());
            $mail->Subject = ($emailMessage->getSubject()->getEmailSubject());
            $mail->msgHTML($emailMessage->getEmailBody()->getEmailBody());
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
