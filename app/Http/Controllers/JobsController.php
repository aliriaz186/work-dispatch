<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DispatchJob;
use App\Jobs\CustomerJobCreatedEmail;
use App\Jobs\JobScheduledForCustomer;
use App\Jobs\JobScheduledForTechnician;
use App\ScheduledJob;
use App\Technician;
use App\Worker;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use services\email_services\EmailAddress;

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
            $workerEmail = Worker::where('id',  $request->selectedWorker)->first()['email'];
            JobScheduledForCustomer::dispatch(new EmailAddress($customerEmail), $request->jobId, $scheduleJob->id);
            JobScheduledForTechnician::dispatch(new EmailAddress($workerEmail), $request->jobId, $scheduleJob->id);
            return json_encode(['status' => $result]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'There is error on server side. Please try again!']);
        }

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
        return view('dashboard.job-details')->with(['job' => $job, 'customer' => $customer, 'technician' => $technician, 'workers' => $workers, 'schedule' => $schedule, 'workerName' => $workerName]);
    }

}
