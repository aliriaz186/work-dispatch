<?php

namespace App\Jobs;

use Firebase\JWT\JWT;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use services\email_messages\JobScheduleForCustomerMessage;
use services\email_messages\TechnicianOnItsWayMessage;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class TechnicianOnItsWayEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $userEmail;
    private $jobId;
    private $schedulesId;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EmailAddress $userEmail, string $jobId,int $schedulesId)
    {
        $this->userEmail = $userEmail;
        $this->schedulesId = $schedulesId;
        $this->jobId = JWT::encode(['jobId' => $jobId], 'dispatchEncodeSecret-2020');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = new SendEmailService(new EmailSubject("Technician is on his way to your location!"));
        $mailTo = $this->userEmail;
        $invitationMessage = new TechnicianOnItsWayMessage();
        $emailBody = $invitationMessage->message($this->jobId, $this->schedulesId);
        $body = new EmailBody($emailBody);
        $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
        $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2020")));
        $result = $sendEmail->send($emailMessage);
        return json_encode($result);

    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        //
    }
}
