<?php

namespace App\Http\Controllers;

use App\JobRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function getView(){
        $jobRating = JobRating::where('technicianId', Session::get('userId'))->get();
        return view('dashboard.reviews')->with(['reviews' => $jobRating]);
    }
}
