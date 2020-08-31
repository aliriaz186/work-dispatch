<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DispatchJob;
use App\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $customersCount = Customer::all()->count();
        $technicianCount = Technician::all()->count();
        $jobsCount = DispatchJob::all()->count();
        $awaitingJobAcceptanceCount = DispatchJob::where(['id_technician' => Session::get('userId'), 'status' => 'offered'])->count();
        $openJobsCount = DispatchJob::where(['id_technician' => Session::get('userId'), 'status' => 'offered'])->count();
        $closedJobsCount = DispatchJob::where(['id_technician' => Session::get('userId'), 'status' => 'Completed'])->count();
        $jobsReceivedCount = DispatchJob::where('id_technician', Session::get('userId'))->count();
        return view('dashboard/dashboard')->with(['jobsReceivedCount' => $jobsReceivedCount,'closedJobsCount' => $closedJobsCount,'openJobsCount' => $openJobsCount,'awaitingJobAcceptanceCount' => $awaitingJobAcceptanceCount,'customersCount' => $customersCount,'technicianCount' => $technicianCount,'jobsCount' => $jobsCount]);
    }

    public function profile(){
        $technician = Technician::where('id', Session::get('userId'))->first();
        return view('dashboard/profile')->with(['technician' => $technician]);
    }

    public function updateLogo(Request $request){
        try {
            $technician = Technician::where(['id' => Session::get('userId')])->first();
            if ($request->hasfile('files')) {
                $file = $request->file('files')[0];
                $name = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() . '/logo/', $name);
                if (!empty($technician->logo)) {
                    if (File::exists(public_path() . '/logo/'. $technician->logo)) {
                        File::delete(public_path() . '/logo/'. $technician->logo);
                    }
                }
                $technician->logo = $name;
            }
            $technician->update();
            return json_encode(['status' => true]);
        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Failed to save data. There is error on server side!', 'error' => $exception->getMessage()]);
        }
    }

}
