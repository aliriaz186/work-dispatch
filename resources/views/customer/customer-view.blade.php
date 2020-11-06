@extends('customer.layout')
<!-- begin:: Content -->
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <div id="listing_form" class="form-horizontal listing_form">
            <div class="row">

                <div class="col-xl-12 order-lg-12 order-xl-12">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg" style="padding: 20px;background-color: lightblue">
                            <div class="kt-portlet__head-label col-lg-12">
                                <div class="col-lg-12">
                                    <div>
                                        <h1 style="font-weight: 500;font-size: 20px;text-align: center;color: white!Important"
                                            class="kt-portlet__head-title text-uppercase">
                                            Welcome {{$customer->name}}
                                        </h1>
                                    </div>
                                    <div class="row" style="padding-top: 12px;">
                                        <div class="col-lg-4">
                                            <h3 class="kt-portlet__head-title text-uppercase" style="font-size: 14px;color: white">
                                             <span class="kt-portlet__head-icon">
                                            <i style="color: white!important;" class="kt-font-brand fas fa-briefcase"></i>
                                        </span>
                                                {{$job->title}}
                                            </h3>
                                        </div>
                                        <div class="col-lg-4" style="text-align: center">
                                            <h3 class="kt-portlet__head-title text-uppercase mt-1"
                                                style="font-size: 14px;color: white!important">
                                                Claim No: {{$job->id}}
                                            </h3>
                                        </div>
                                        <div class="col-lg-4" style="text-align: center">
                                            <h3 class="kt-portlet__head-title text-uppercase mt-1"
                                                style="font-size: 14px;color: white">
                                                Status: {{$job->status}}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="jobId" value="{{$job->id}}">
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg" style="padding-left: 0">
                            <div class="kt-portlet__head-label" style="padding: 20px;padding-left: 0">
                                <ul class="stepper stepper-horizontal" style="list-style: none;padding-top: 15px">
                                    <li class="completed" style="text-decoration: none!important;">
                                        <h3 class="kt-portlet__head-title text-uppercase">
                                            <i class="fas fa-check-circle"
                                               style="color: green; font-size: 18px"></i> Claim Created
                                        </h3>
                                        <div class="row">
                                            @if(!empty($schedule) || $job->status == "unscheduled")

                                                <div
                                                    style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">
                                                    |
                                                </div>
                                            @else
                                                <div
                                                    style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                    |
                                                </div>
                                            @endif
                                            <p style="padding-left: 20px; margin-top: 20px">
                                                Your claim has been created in {{env('APP_NAME')}}
                                            </p>
                                        </div>
                                    </li>
                                        @if($job->status != "offered")
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "unscheduled" || $job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                            <h3 class="kt-portlet__head-title text-uppercase">
                                                <i class="fas fa-check-circle"
                                                   style="color: green; font-size: 18px"></i> Claim Accepted
                                            </h3>
                                                <div class="row">
                                                    @if($job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">
                                                            |
                                                        </div>
                                                    @else
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                            |
                                                        </div>
                                                    @endif
                                                    <p style="padding-left: 20px; margin-top: 20px">
                                                        Your claim has been accepted
                                                    </p>
                                                </div>
                                            @elseif($job->status == "rejected")
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="far fa-times-circle"
                                                       style="background: red;color: white;font-size: 18px;border: 1px solid red;border-radius: 16px;"></i> Claim Rejected
                                                </h3>
                                                <div class="row">
                                                    @if($job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">
                                                            |
                                                        </div>
                                                    @else
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                            |
                                                        </div>
                                                    @endif
                                                    <p style="padding-left: 20px; margin-top: 20px">
                                                        Your claim has been rejected
                                                    </p>
                                                </div>
                                                <div>
                                                    <p><span style="font-weight: bold;font-size: 15px;text-decoration: underline;">Service Provider Rejection Message:</span></p>
                                                    <p> {{\App\RejectClaimReason::where('job_id', $job->id)->first()['customer_message']}}</p>
                                                </div>
                                            @endif
{{--                                            <div class="row">--}}
{{--                                                @if($job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")--}}
{{--                                                    <div--}}
{{--                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">--}}
{{--                                                        |--}}
{{--                                                    </div>--}}
{{--                                                @else--}}
{{--                                                    <div--}}
{{--                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">--}}
{{--                                                        |--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                                <p style="padding-left: 20px; margin-top: 20px">--}}
{{--                                                    Your claim has been accepted--}}
{{--                                                </p>--}}
{{--                                            </div>--}}
                                        </li>
                                    @endif

                                        <li class="completed" style="text-decoration: none!important;">
                                            @if(!empty($schedule))
                                                @if($job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                                    <h3 class="kt-portlet__head-title text-uppercase">
                                                        <i class="fas fa-check-circle"
                                                           style="color: green; font-size: 18px"></i> Claim has been
                                                        Scheduled and Your Technician has been <br> Scheduled on {{$schedule->date}} between
                                                        ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})
                                                    </h3>
                                                @else
                                                    <h3 class="kt-portlet__head-title text-uppercase">
                                                        <i class="fas fa-check-circle"
                                                           style="color: grey; font-size: 18px"></i> Claim has been
                                                        Scheduled and Your Technician has been <br> Scheduled on {{$schedule->date}} between
                                                        ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})
                                                    </h3>
                                                @endif
                                                <div class="row">
                                                    @if($job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                                        <div
                                                            style="margin-left:12px;font-size: 61px;font-weight: 200;color: green;">
                                                            |
                                                        </div>
                                                    @else
                                                        <div
                                                            style="margin-left:12px;font-size: 61px;font-weight: 200;color: grey;">
                                                            |
                                                        </div>
                                                    @endif
                                                        @if(\App\ClaimRescheduleNotHome::where('job_id', $job->id)->exists())
                                                            <p style="padding-left: 20px; margin-top: 20px">
                                                                We missed you, and will try you again
                                                                on {{$schedule->date}} between
                                                                ({{$schedule->est_time_from}}
                                                                - {{$schedule->est_time_to}})<br>
                                                                Company Name : {{$technician->company_name}}<br>
                                                                Technician : {{$worker->name}} (<a
                                                                    href="tel:{{$worker->phone}}">{{$worker->phone}}</a>)
                                                                <a style="text-decoration: underline"
                                                                   href="tel:{{$worker->phone}}">Call Technician</a>
                                                                <a style="text-decoration: underline"
                                                                   href="sms:{{$worker->phone}}">Send SMS</a>
                                                            </p>
                                                        @else
                                                            <p style="padding-left: 20px; margin-top: 20px">
                                                                Your claim has been scheduled on {{$schedule->date}}
                                                                between
                                                                ({{$schedule->est_time_from}}
                                                                - {{$schedule->est_time_to}})<br>
                                                                Company Name : {{$technician->company_name}}<br>
                                                                Technician : {{$worker->name}} (<a
                                                                    href="tel:{{$worker->phone}}">{{$worker->phone}}</a>)
                                                                <a style="text-decoration: underline"
                                                                   href="tel:{{$worker->phone}}">Call Technician</a>
                                                                <a style="text-decoration: underline"
                                                                   href="sms:{{$worker->phone}}">Send SMS</a>
                                                            </p>
                                                        @endif
                                                </div>
                                            @else
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: grey; font-size: 18px"></i> Claim has been Scheduled and Your Technician has been <br> Scheduled on {{$schedule->date ?? ''}} between
                                                    ({{$schedule->est_time_from ?? ''}} - {{$schedule->est_time_to ?? ''}})
                                                </h3>
                                                <div class="row">
                                                    <div
                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                        |
                                                    </div>
                                                    <p style="padding-left: 20px; margin-top: 20px">
                                                        Not Scheduled Yet!
                                                    </p>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed" || $job->status == "Follow Up")
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: green; font-size: 18px"></i> Technician is on its way
                                                </h3>
                                                <div class="row">
                                                    @if($job->status == "Job Started" || $job->status == "Completed")
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">
                                                            |
                                                        </div>
                                                    @else
                                                        <div
                                                            style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                            |
                                                        </div>
                                                    @endif
                                                    <p style="padding-left: 20px; margin-top: 20px">
                                                        Technician is on its way, He will be at your location shortly.
                                                    </p>
                                                </div>
                                            @else
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: grey; font-size: 18px"></i> Technician is on its way
                                                </h3>
                                                <div class="row">
                                                    <div
                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                        |
                                                    </div>
                                                    <p style="padding-left: 20px; margin-top: 20px">
                                                        Technician is on its way, He will be at your location shortly.
                                                    </p>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "Job Started" || $job->status == "Completed" || $job->status == "Follow Up")

                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: green; font-size: 18px"></i> Technician has arrived and Started work
                                                </h3>
                                            @else
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: grey; font-size: 18px"></i> Technician has arrived and Started work
                                                </h3>
                                            @endif
                                            <div class="row">
                                                @if($job->status == "Completed")
                                                    <div
                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: green;">
                                                        |
                                                    </div>
                                                @else
                                                    <div
                                                        style="margin-left:12px;font-size: 40px;font-weight: 500;color: grey;">
                                                        |
                                                    </div>
                                                @endif
                                                <p style="padding-left: 20px; margin-top: 20px">
                                                    Technician started the claim
                                                </p>
                                            </div>
                                        </li>
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "Completed")

                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: green; font-size: 18px"></i> Claim has been successfully completed
                                                </h3>
                                            @else
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    <i class="fas fa-check-circle"
                                                       style="color: grey; font-size: 18px"></i> Claim has been successfully completed
                                                </h3>
                                            @endif
                                            <p style="padding-left: 20px; margin-top: 20px">
                                                Technician completed the claim
                                            </p>
                                            {{--                                                    <p style="padding-left: 20px; margin-top: 20px">Reviews</p>--}}
                                        </li>
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "Follow Up")
                                                <h4 class="ml-5">Status</h4>
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    Follow Up
                                                </h3>
                                            @endif
                                        </li>
                                        <li class="completed" style="text-decoration: none!important;">
                                            @if($job->status == "rejected")
                                                <h4 class="ml-5">Status</h4>
                                                <h3 class="kt-portlet__head-title text-uppercase">
                                                    -- Claim Denied --
                                                </h3>
                                                <a target="_blank" href="{{env('ADMIN_URL')}}/jobs/{{$job->id}}/details" style="text-decoration: underline;cursor: pointer">Click here for more Info</a>
                                            @endif
                                        </li>
                                    @if($job->status == "Completed")
                                    <li class="completed" style="text-decoration: none!important;">
                                        @if($ratingStatus)
                                            <h4 class="mt-4">Thanks for your feedback!</h4>
                                        @else
                                        <form method="post" action="{{url("/give-rating")}}" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="hidden" id="jobId" name="jobId" value="{{$job->id}}">
                                            <input type="hidden" id="workerId" name="workerId" value="{{$worker->id}}">
                                            <input type="hidden" id="technicianId" name="technicianId" value="{{$technician->id}}">
                                        <h4 class="">Let us know how we did?</h4>
                                        <div>
                                            <div class="rate ml-4">
                                                <input type="radio" id="star5" name="rate" value="5"/>
                                                <label for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4"/>
                                                <label for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3"/>
                                                <label for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2"/>
                                                <label for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1"/>
                                                <label for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <div>
                                            <div class="input-group">
                                                <textarea rows="6" cols="30" id="additionalComments" name="additionalComments" placeholder="Addition Comments"></textarea>
                                            </div>
                                        </div>
                                            <div class="mt-2">
                                                <button class="btn btn-brand">Submit</button>
                                            </div>
                                        </form>
                                        @endif
                                    </li>
                                    @endif
                                    </ul>

                                </div>

                                <div class="kt-portlet__head-label" style="padding: 20px">
                                    <img style="object-fit: contain;width: 519px;height: 382px;"
                                         src="{{env('ADMIN_URL')}}/media/dummy-claim-pic.png">
                                </div>

                            </div>
                        </div>

                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg" style="background-color: lightblue">
                                <div class="kt-portlet__head-label">
                                <span class="kt-portlet__head-icon">
                                    <i style="color: white!important" class="kt-font-brand fas fa-briefcase"></i>
                                </span>
                                    <h3 class="kt-portlet__head-title text-uppercase" style="color: white">
                                        Claim Location ({{$job->job_address}})
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg" style="padding: 0px !important;">
                                <div class="kt-portlet__head-label">
                                </div>
                                <div id="map" style="height:541px!important;width:100%;"></div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <p id="long" style="display: none">{{$job->long}}</p>
            <p id="lat" style="display: none">{{$job->lat}}</p>
            <script>
                let marker = false; ////Has the user plotted their location marker?
                let lati = parseFloat(document.getElementById('lat').innerText);
                let longi = parseFloat(document.getElementById('long').innerText);
                let map, infoWindow, geocoder;
                function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 15,
                        center: {lat: lati, lng: longi}
                    });
                    geocoder = new google.maps.Geocoder;
                    infoWindow = new google.maps.InfoWindow;
                    let clickedLocation = {lat: lati, lng: longi};
                    if(marker === false){
                        marker = new google.maps.Marker({
                            position: clickedLocation,
                            map: map,
                            title : "Job Location"
                        });
                    } else{
                        marker.setPosition(clickedLocation);
                    }

                }

            </script>
            <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJqJcwaHOlWKivApYFYSjmVobGeKFqGdE&callback=initMap">
            </script>
        </div>
        <script>
            $(document).ready(function () {
            });

            function onMyWay() {
                let data = new FormData();
                let jobId = document.getElementById('jobId').value;
                data.append("_token", "{{ csrf_token() }}");
                data.append("jobId", jobId);
                KTApp.blockPage({
                    baseZ: 2000,
                    overlayColor: '#000000',
                    type: 'v1',
                    state: 'danger',
                    opacity: 0.15,
                    message: 'Processing...'
                });
                $.ajax({
                    url: "{{env('APP_URL')}}/job/on-my-way",
                    type: 'POST',
                    dataType: "JSON",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (result) {
                        if (result['status']) {
                            // Disable Page Loading and show confirmation
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": "Job Status updated Successfully",
                                    "type": "success",
                                    "showConfirmButton": false,
                                    "timer": 1500,
                                    "onClose": function (e) {
                                        window.location.reload();
                                    }
                                })
                            }, 2000);
                        } else {
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": result['message'],
                                    "type": "error",
                                    "confirmButtonClass": "btn btn-secondary",
                                    "onClose": function (e) {
                                        console.log('on close event fired!');
                                    }
                                })
                            }, 2000);
                        }
                    }
                });
            }

            function startJob() {
                let data = new FormData();
                let jobId = document.getElementById('jobId').value;
                data.append("_token", "{{ csrf_token() }}");
                data.append("jobId", jobId);
                KTApp.blockPage({
                    baseZ: 2000,
                    overlayColor: '#000000',
                    type: 'v1',
                    state: 'danger',
                    opacity: 0.15,
                    message: 'Processing...'
                });
                $.ajax({
                    url: "{{env('APP_URL')}}/job/start",
                    type: 'POST',
                    dataType: "JSON",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (result) {
                        if (result['status']) {
                            // Disable Page Loading and show confirmation
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": "Job started Successfully",
                                    "type": "success",
                                    "showConfirmButton": false,
                                    "timer": 1500,
                                    "onClose": function (e) {
                                        window.location.reload();
                                    }
                                })
                            }, 2000);
                        } else {
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": result['message'],
                                    "type": "error",
                                    "confirmButtonClass": "btn btn-secondary",
                                    "onClose": function (e) {
                                        console.log('on close event fired!');
                                    }
                                })
                            }, 2000);
                        }
                    }
                });
            }

            function completeJob() {
                let data = new FormData();
                let jobId = document.getElementById('jobId').value;
                data.append("_token", "{{ csrf_token() }}");
                data.append("jobId", jobId);
                KTApp.blockPage({
                    baseZ: 2000,
                    overlayColor: '#000000',
                    type: 'v1',
                    state: 'danger',
                    opacity: 0.15,
                    message: 'Processing...'
                });
                $.ajax({
                    url: "{{env('APP_URL')}}/job/complete",
                    type: 'POST',
                    dataType: "JSON",
                    data: data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (result) {
                        if (result['status']) {
                            // Disable Page Loading and show confirmation
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": "Job Completed Successfully",
                                    "type": "success",
                                    "showConfirmButton": false,
                                    "timer": 1500,
                                    "onClose": function (e) {
                                        window.location.reload();
                                    }
                                })
                            }, 2000);
                        } else {
                            setTimeout(function () {
                                KTApp.unblockPage();
                            }, 1000);
                            setTimeout(function () {
                                swal.fire({
                                    "title": "",
                                    "text": result['message'],
                                    "type": "error",
                                    "confirmButtonClass": "btn btn-secondary",
                                    "onClose": function (e) {
                                        console.log('on close event fired!');
                                    }
                                })
                            }, 2000);
                        }
                    }
                });
            }

        </script>
    @endsection
