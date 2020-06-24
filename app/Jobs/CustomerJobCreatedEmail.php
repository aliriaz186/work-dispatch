<?php

namespace App\Jobs;

use Firebase\JWT\JWT;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use services\email_messages\InvitationMessageBody;
use services\email_messages\JobCreationMessage;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class CustomerJobCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $userEmail;
    private $jobId;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EmailAddress $userEmail, string $jobId)
    {
        $this->userEmail = $userEmail;
        $this->jobId = JWT::encode(['jobId' => $jobId], 'dispatchEncodeSecret-2020');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = new SendEmailService(new EmailSubject("Hi, Your job has been Created in "."   ". env('APP_NAME')));
        $mailTo = $this->userEmail;
        $invitationMessage = new JobCreationMessage();
        $emailBody = $invitationMessage->creationMessage($this->jobId);
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
