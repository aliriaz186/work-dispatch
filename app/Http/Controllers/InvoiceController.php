<?php

namespace App\Http\Controllers;

use App\DispatchJob;
use App\JobInvoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function getView()
    {
        $arr = [];
        $invoices = JobInvoices::all();
        foreach ($invoices as $item) {
            $dispatchJob = DispatchJob::where('id', $item->job_id)->first();
            if (Session::get('userId') == $dispatchJob->id_technician) {
                array_push($arr, $item);
            }
        }
        return view('dashboard.invoices')->with(['invoices' => $arr]);
    }

    public function updateInvoice(Request $request)
    {
        $jobInvoices = JobInvoices::where('id', $request->invoiceId)->first();
        $jobInvoices->status = $request->invoiceStatus;
        $jobInvoices->update();
    }

    public function newInvoiceView()
    {
        $jobId = DispatchJob::where('id_technician', Session::get('userId'))->get();
        return view('dashboard.new-invoice')->with(['jobId' => $jobId]);
    }

    public function saveNewInvoice(Request $request)
    {
        $file = $request->file('images')[0];
        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/new-invoices/', $name);
        $jobInvoices = new JobInvoices();
        $jobInvoices->job_id = $request->jobId;
        $jobInvoices->invoice = $name;
        $jobInvoices->status = 'open';
        $jobInvoices->save();
        return redirect('invoices');
    }
}
