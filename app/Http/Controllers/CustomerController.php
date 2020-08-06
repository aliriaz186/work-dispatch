<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DispatchJob;
use App\ScheduledJob;
use App\Technician;
use App\Worker;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function getView()
    {
        return view('dashboard.customers');
    }

    public function getAll(Request $request)
    {
        $dispatchJobs = DispatchJob::where('id_technician', Session::get('userId'))->get();
        $customerIdList = [];
        foreach ($dispatchJobs as $job){
            array_push($customerIdList, $job->id_customer);
        }
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
        );
        $totalData = Customer::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {
            $customers = Customer::whereIn('id', $customerIdList)->offset($start)->limit($limit)->get();
        } else {
            $search = $request->input('search.value');
            $customers = Customer::whereIn('id', $customerIdList)->where('id', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->get();
            $totalFiltered = Customer::whereIn('id', $customerIdList)->where('id', 'LIKE', "%{$search}%")->count();
        }
        $data = array();
        if (!empty($customers)) {
            foreach ($customers as $customer) {
                $nestedData['id'] = $customer->id;
                $nestedData['name'] = $customer->name;
                $nestedData['email'] = $customer->email;
                $nestedData['phone'] = $customer->phone;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function sendMessage($recipients, $message){
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new \Twilio\Rest\Client($account_sid, $auth_token);
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }

    public function manage(int $id)
    {
        $customer = Customer::where('id', $id)->first();
        return view('dashboard.edit-customer')->with(['customer' => $customer]);
    }

    public function update(Request $request)
    {
        try {
            $customer = Customer::where('id', $request->id)->first();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            return json_encode(['status' =>  $customer->update()]);
        } catch (\Exception $exception) {
            return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function trackJob(string $token){
        try {
            $token = JWT::decode($token, 'dispatchEncodeSecret-2020', array('HS256'));
            $jobId = $token->jobId;
            $job = DispatchJob::where('id', $jobId)->first();
            $customer = Customer::where('id', $job->id_customer)->first();
            $technician = Technician::where('id', $job->id_technician)->first();
            $schedule = ScheduledJob::where('id_job', $jobId)->first();
            if (!empty($schedule)){
                $worker = Worker::where('id', $schedule->id_worker)->first();
            }else{
                $worker ="";
            }
            return view('customer.customer-view')->with(['job' => $job, 'customer' => $customer, 'technician' => $technician, 'schedule' => $schedule, "worker" => $worker]);
        }catch (\Exception $exception){
            return json_encode("Access Denied.");
        }
    }
}
