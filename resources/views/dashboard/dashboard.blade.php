@extends('dashboard.layout')
<!-- begin:: Content -->
@section('content')
 <div class="row">
     <div class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3">
         <div class="kt-portlet kt-portlet--height-fluid">
             <div class="kt-widget14">
                 <div class="kt-widget14__header kt-margin-b-30">
                     <h3 class="text-center">
                         Total Awaiting Claim Acceptance
                     </h3>
                 </div>
                 <h3 class="text-center">{{$awaitingJobAcceptanceCount}}+</h3>
             </div>
         </div>
     </div>
     <div class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3">
         <div class="kt-portlet kt-portlet--height-fluid">
             <div class="kt-widget14">
                 <div class="kt-widget14__header kt-margin-b-30">
                     <h3 class="text-center">
                         Total Open Claims
                     </h3>
                 </div>
                 <h3 class="text-center">{{$openJobsCount}}+</h3>
             </div>
         </div>
     </div>
     <div class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3">
         <div class="kt-portlet kt-portlet--height-fluid">
             <div class="kt-widget14">
                 <div class="kt-widget14__header kt-margin-b-30">
                     <h3 class="text-center">
                         Total Closed Claims
                     </h3>
                 </div>
                 <h3 class="text-center">{{$closedJobsCount}}+</h3>
             </div>
         </div>
     </div>
     <div class="col-xl-3 col-lg-3 order-lg-3 order-xl-2 ml-3">
         <div class="kt-portlet kt-portlet--height-fluid">
             <div class="kt-widget14">
                 <div class="kt-widget14__header kt-margin-b-30">
                     <h3 class="text-center">
                         Total Claims Received
                     </h3>
                 </div>
                 <h3 class="text-center">{{$jobsReceivedCount}}+</h3>
             </div>
         </div>
     </div>
 </div>
@endsection
