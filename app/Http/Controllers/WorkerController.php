<?php

namespace App\Http\Controllers;

use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WorkerController extends Controller
{
    public function getWorkerView()
    {
        return view('dashboard.workers');
    }

    public function newWorker()
    {
        return view('dashboard.new-worker');
    }

    public function editWorker(int $id)
    {
        return view('dashboard.edit-worker')->with(['worker' => Worker::where('id', $id)->first()]);
    }

    public function saveWorker(Request $request)
    {
        try {
            $worker = new Worker();
            $worker->name = $request->name;
            $worker->email = $request->email;
            $worker->phone = $request->phone;
            $worker->id_technician = Session::get('userId');
            $result = $worker->save();
            return json_encode(['status' => $result]);
        } catch (\Exception $exception) {
                return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function updateWorker(Request $request)
    {
        try {
            $worker = Worker::where('id', $request->id)->first();
            $worker->name = $request->name;
            $worker->email = $request->email;
            $worker->phone = $request->phone;
            $result = $worker->update();
            return json_encode(['status' => $result]);
        } catch (\Exception $exception) {
                return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function getAll(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'email',
            3 => 'phone',
            4 => 'address',
            5 => 'website',
            6 => 'options',
        );
        $totalData = Worker::where('id_technician', Session::get('userId'))->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        if (empty($request->input('search.value'))) {
            $providers = Worker::where('id_technician', Session::get('userId'))->offset($start)->limit($limit)->get();
        } else {
            $search = $request->input('search.value');
            $providers = Worker::where('id_technician', Session::get('userId'))->where('id', 'LIKE', "%{$search}%")->offset($start)->limit($limit)->get();
            $totalFiltered = Worker::where('id_technician', Session::get('userId'))->where('id', 'LIKE', "%{$search}%")->count();
        }
        $data = array();
        if (!empty($providers)) {
            foreach ($providers as $provider) {
                $appUrl = env('APP_URL');
                $nestedData['id'] = $provider->id;
                $nestedData['name'] = $provider->name;
                $nestedData['email'] = $provider->email;
                $nestedData['phone'] = $provider->phone;
                $nestedData['address'] = $provider->address;
                $nestedData['website'] = $provider->website;
                $nestedData['options'] = '<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                           data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="kt-nav">
                                                <li class="kt-nav__item">
                                                    <a href="' . env('APP_URL') . '/workers/manage/' . $provider->id . '"
                                                       class="kt-nav__link">
                                                        <i class="kt-nav__link-icon flaticon2-settings"></i>
                                                        <span class="kt-nav__link-text">Manage</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>';
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
}
