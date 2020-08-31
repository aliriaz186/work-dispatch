<?php

namespace App\Http\Controllers;

use App\ClaimFollowUp;
use App\ClaimReschedule;
use App\Customer;
use App\DispatchJob;
use App\JobImages;
use App\JobRating;
use App\Jobs\CustomerJobCreatedEmail;
use App\Jobs\JobScheduledForCustomer;
use App\Jobs\JobScheduledForTechnician;
use App\ScheduledJob;
use App\Technician;
use App\Worker;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use services\email_messages\JobScheduleForCustomerMessage;
use services\email_messages\JobScheduleForTechnicanMessage;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class JobsController extends Controller
{
    public function getView(){
        $technician = Technician::where('id', Session::get('userId'))->first();
        $jobs = DispatchJob::where('id_technician', Session::get('userId'))->orderBy('created_at', 'DESC')->get();
        foreach ($jobs as $job){
            $job->customer = Customer::where('id', $job->id_customer)->first();
        }
        return view('dashboard.jobs')->with(['jobs' => $jobs, 'technician' => $technician]);
    }

    public function newJobView(){
        return view('dashboard.new-job');
    }

    public function acceptJob(Request $request){
        try {
            $job = DispatchJob::where('id', $request->jobId)->first();
            $job->status = 'unscheduled';
            return json_encode(['status' => $job->update()]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'There is error on server side. Please try again!']);
        }
    }

    public function rejectJob(Request $request){
        try {
            $job = DispatchJob::where('id', $request->jobId)->first();
            $job->status = 'rejected';
            return json_encode(['status' => $job->update()]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'There is error on server side. Please try again!']);
        }
    }

    public function scheduleJob(Request $request){
        try {
            $scheduleJob = new ScheduledJob();
            $scheduleJob->date = $request->date;
            $scheduleJob->est_time_from = $request->estStart;
            $scheduleJob->est_time_to = $request->estEnd;
            $scheduleJob->id_worker = $request->selectedWorker;
            $scheduleJob->id_job = $request->jobId;
            $job = DispatchJob::where('id', $request->jobId)->first();
            $job->status = 'scheduled';
            $job->update();
            $result = $scheduleJob->save();
            $customerEmail = Customer::where('id', $job->id_customer)->first()['email'];
            $customerPhone = Customer::where('id', $job->id_customer)->first()['phone'];
            $workerEmail = Worker::where('id',  $request->selectedWorker)->first()['email'];
            $workerPhone = Worker::where('id',  $request->selectedWorker)->first()['phone'];
//            JobScheduledForCustomer::dispatch(new EmailAddress($customerEmail), $request->jobId, $scheduleJob->id);
//            JobScheduledForTechnician::dispatch(new EmailAddress($workerEmail), $request->jobId, $scheduleJob->id);
            $subject = new SendEmailService(new EmailSubject("Hi, Your claim has been Scheduled in "."   ". env('APP_NAME')));
            $mailTo = new EmailAddress($customerEmail);
            $this->schedulesId = $scheduleJob->id;
            $this->jobId = JWT::encode(['jobId' => $request->jobId], 'dispatchEncodeSecret-2020');
            $invitationMessage = new JobScheduleForCustomerMessage();
            $emailBody = $invitationMessage->message($this->jobId, $this->schedulesId);
            $textEmailBody = $invitationMessage->textMessage($this->jobId, $this->schedulesId);
            $body = new EmailBody($emailBody);
            $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
            $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2020")));
            $result = $sendEmail->send($emailMessage);
//            $this->sendMessage($customerPhone, $textEmailBody);



            $subject = new SendEmailService(new EmailSubject("Hi, A claim assigned to you in "."   ". env('APP_NAME')));
            $mailTo = new EmailAddress($workerEmail);
            $this->schedulesId = $scheduleJob->id;
            $this->jobId = JWT::encode(['jobId' => $request->jobId], 'dispatchEncodeSecret-2020');
            $invitationMessage = new JobScheduleForTechnicanMessage();
            $emailBody = $invitationMessage->message($this->jobId, $this->schedulesId);
            $textEmailBody = $invitationMessage->textMessage($this->jobId, $this->schedulesId);
            $body = new EmailBody($emailBody);
            $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
            $sendEmail = new EmailSender(new PhpMail(new MailConf("smtp.gmail.com", "admin@dispatch.com", "secret-2020")));
            $result = $sendEmail->send($emailMessage);
//            $this->sendMessage($workerPhone, $textEmailBody);
            return json_encode(['status' => $result]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }

    }

    public function sendMessage($recipients, $message){
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }

    public function saveJob(Request $request){
        try {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();
            $job = new DispatchJob();
            $job->job_address = $request->address;
            $job->lat = $request->lat;
            $job->long = $request->longg;
            $job->id_technician = $request->technician_id;
            $job->id_customer = $customer->id;
            $job->title = $request->title;
            $job->description = $request->description;
            $job->service_type = $request->service_type;
            $job->customer_availability_one = $request->customer_availability_one;
            $job->customer_availability_two = $request->customer_availability_two;
            $job->customer_availability_three = $request->customer_availability_three;
            $job->notes = $request->notes;
            $job->status = "offered";
            $result = $job->save();
            CustomerJobCreatedEmail::dispatch(new EmailAddress($customer->email), $job->id);
            return json_encode(['status' => $result]);
        } catch (\Exception $exception) {
            return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function getAll(Request $request){
        $columns = array(
            0 =>'id',
            1 =>'status',
            2=> 'customer',
            3=> 'technician',
            4=> 'title',
            5=> 'address',
        );
        $totalData = DispatchJob::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if(empty($request->input('search.value')))
        {
            $jobs = DispatchJob::offset($start)->limit($limit)->get();
        }
        else {
            $search = $request->input('search.value');
            $jobs =  DispatchJob::where('id','LIKE',"%{$search}%")->orWhere('status', 'LIKE',"%{$search}%")->orWhere('title', 'LIKE',"%{$search}%")->offset($start)->limit($limit)->get();
            $totalFiltered = DispatchJob::where('id','LIKE',"%{$search}%")->orWhere('status', 'LIKE',"%{$search}%")->orWhere('title', 'LIKE',"%{$search}%")->count();
        }
        $data = array();
        if(!empty($jobs))
        {
            foreach ($jobs as $job)
            {
                $customer = Customer::where('id', $job->id_customer)->first();
                $technician = Technician::where('id', $job->id_technician)->first();
                $appUrl = env('APP_URL');
                $nestedData['id'] = "<a href='$appUrl/jobs/$job->id/details' style='color: #5d78ff'>$job->id</a>";
                $nestedData['status'] = $job->status;
                $nestedData['customer'] = "<a href='$appUrl/jobs/$job->id/details' style='color: #5d78ff'>$customer->name ($customer->phone)</a>";
                $nestedData['technician'] =  "<a href='$appUrl/jobs/$job->id/details' style='color: #5d78ff'>$technician->name ($technician->phone)</a>";
                $nestedData['title'] =  $job->title;
                $nestedData['address'] =  $job->job_address;
                $data[] = $nestedData;
            }
        }

        $jsonData = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($jsonData);
    }

    public function getJobDetails(int $jobId){
        $job = DispatchJob::where('id', $jobId)->first();
        $customer = Customer::where('id', $job->id_customer)->first();
        $technician = Technician::where('id', $job->id_technician)->first();
        $workers = Worker::where('id_technician', $job->id_technician)->get();
        $schedule = ScheduledJob::where('id_job', $jobId)->first();
        if (!empty($schedule)){
            $workerName = Worker::where('id', $schedule->id_worker)->first()['name'];
        }else{
            $workerName = '';
        }
        $jobImages = JobImages::where('job_id', $jobId)->get();
        $ratings = JobRating::where('jobId', $jobId)->first();
        return view('dashboard.job-details')->with(['ratings' => $ratings,'jobImages' => $jobImages,'job' => $job, 'customer' => $customer, 'technician' => $technician, 'workers' => $workers, 'schedule' => $schedule, 'workerName' => $workerName]);
    }

    public function followUpReasonStore(Request $request){
        $claimFollowUp = new ClaimFollowUp();
        $claimFollowUp->job_id = $request->jobId;
        $claimFollowUp->reason = $request->reason;
        $claimFollowUp->save();
        $dispatchJob = DispatchJob::where('id', $request->jobId)->first();
        $dispatchJob->status = 'Follow Up';
        $dispatchJob->update();
        return redirect()->back();
    }

    public function rescheduleClaim(Request $request){
        $claimReschedule = new ClaimReschedule();
        $claimReschedule->job_id = $request->jobId;
        $claimReschedule->reason = $request->reason;
        $claimReschedule->save();
        $dispatchJob = DispatchJob::where('id', $request->jobId)->first();
        $dispatchJob->status = 'scheduled';
        $dispatchJob->update();
        $scheduledJob = ScheduledJob::where('id_job', $request->jobId)->first();
        $scheduledJob->date = $request->sDate;
        $scheduledJob->update();
        return redirect()->back();
    }

    public function giveRating(Request $request){
        $jobRating = new JobRating();
        $jobRating->jobId = $request->jobId;
        $jobRating->workerId = $request->workerId;
        $jobRating->technicianId = $request->technicianId;
        $jobRating->rating = $request->rate;
        $jobRating->additional_comments = $request->additionalComments;
        $jobRating->save();
        return redirect()->back();
    }

}
