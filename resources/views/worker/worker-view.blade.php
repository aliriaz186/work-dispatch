@extends('worker.layout')
<!-- begin:: Content -->
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <div id="listing_form" class="form-horizontal listing_form">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-xl-6 order-lg-6 order-xl-6">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand fas fa-briefcase"></i>
                            </span>
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    {{$job->title}}
                                </h3>
                                <input type="hidden" id="jobId" value="{{$job->id}}">
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Claim Status
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($job->status == 'scheduled')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">{{$job->status}}</p>
                                        @if(\App\ClaimRescheduleNotHome::where('job_id', $job->id)->exists())
                                            <p>We missed you, and will try you again on {{$schedule->date}} between
                                                ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})</p>
                                        @else
                                            <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}}
                                                - {{$schedule->est_time_to}})</p>
                                        @endif
                                        <p>Change status</p>
                                        <button class="btn btn-brand" onclick="onMyWay()">On my Way</button>
                                    @endif
                                        @if($job->status == 'On My Way')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">You are on your way!</p>
                                            <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}}
                                                - {{$schedule->est_time_to}})</p>
                                            <p>Change status</p>
                                            <button class="btn btn-brand" onclick="startJob()">Start Claim</button>
                                            <button class="btn btn-brand" style="background-color: #0780b7!important;border-color: #0780b7!important" data-toggle="modal" data-target="#modalContactForm3">Customer Was Not Home</button>
                                        @endif
                                        @if($job->status == 'Job Started')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Claim Started!</p>
                                            <p>Change status</p>
                                            <button class="btn btn-brand" data-toggle="modal" data-target="#modalContactForm3">Complete Claim</button>
                                            <button class="btn btn-primary" style="background-color: #0780b7;border-color: #0780b7;color: white;" data-toggle="modal" data-target="#modalContactForm">Needs Follow Up</button>
                                            <button class="btn btn-primary" style="background-color: #0780b7;border-color: #0780b7;color: white;" data-toggle="modal" data-target="#modalContactForm2">Need Reschedule</button>
                                        @endif
                                        @if($job->status == 'Follow Up')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Follow Up</p>
                                        @endif
                                        @if($job->status == 'rejected')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Rejected</p>
                                        @endif
                                        @if($job->status == 'Completed')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Claim Completed!</p>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($job->status == 'Completed')
                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title text-uppercase">
                                        Reviews
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="row">
                                    @if(!empty($ratings->rating))
                                        <div class="col-lg-12">
                                            <p><span
                                                    style="font-weight: 500">Rating:</span> {{$ratings->rating}} out of 5
                                            </p>
                                        </div>
                                        <div class="col-lg-12">
                                            <p><span
                                                    style="font-weight: 500">Additional Comments:</span> {{$ratings->additional_comments}}
                                            </p>
                                        </div>
                                    @else
                                        <div class="col-lg-12">
                                            <p>No reviews yet!</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                @endif

                    <!-- Model -->
                    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">Needs Follow Up</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{url("/followup/reason")}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" id="jobId" name="jobId" value="{{$job->id}}">
                                    <div class="modal-body mx-3">
                                        <div class="md-form">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <label data-error="wrong" data-success="right" for="form8">Your
                                                Reason:</label>
                                            <textarea type="text" id="reason" name="reason"
                                                      class="md-textarea form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-brand">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Model -->
                    <div class="modal fade" id="modalContactForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">Reschedule Claim</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{url("/reschedule/claim")}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" id="jobId" name="jobId" value="{{$job->id}}">
                                    <div class="modal-body mx-3">
                                        <div class="md-form">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <label data-error="wrong" data-success="right" for="form8">Your
                                                Reason:</label>
                                            <textarea type="text" id="reason" name="reason"
                                                      class="md-textarea form-control" rows="4" required></textarea>
                                        </div>
                                        <div class="md-form">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <p>Reschedule Date</p>
                                            <input type="datetime-local" id="sDate" name="sDate" placeholder="Select date" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-brand">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalContactForm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h5 class="modal-title w-100 font-weight-bold">Customer Was Not Home<br><span style="font-weight: 500!important">Reschedule Claim</span></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{url("/customer/not/home/reschedule/claim")}}" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input type="hidden" id="jobId" name="jobId" value="{{$job->id}}">
                                    <div class="modal-body mx-3">
                                        <div class="md-form">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <p>Reschedule Date</p>
                                            <input type="datetime-local" id="sDate" name="sDate" placeholder="Select date" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-brand">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Model -->
                    <div class="modal fade" id="modalContactForm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">Complete Claim</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
{{--                                <form method="post" action="{{url("/reschedule/claim")}}" enctype="multipart/form-data">--}}
{{--                                    {{csrf_field()}}--}}
                                    <input type="hidden" id="jobId" name="jobId" value="{{$job->id}}">
                                    <div class="modal-body mx-3">
                                        <div class="md-form">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <label data-error="wrong" data-success="right" for="form8">Was the issue repaired?</label>
                                            <div class="input-group">
                                                <div class="row col-lg-12 mt-1">
                                                    <input id="issueRepairedYes" name="priorIssue" type="radio" required><span style="margin-top: -3px;margin-left: 6px;">Yes</span>
                                                    <input id="issueRepairedNo" name="priorIssue" style="margin-left: 18px" type="radio" required><span style="margin-top: -3px;margin-left: 6px;">No</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="md-form mt-2">
                                            <i class="fas fa-pencil prefix grey-text"></i>
                                            <label data-error="wrong" data-success="right" for="form8">Conclusion:</label>
                                            <textarea type="text" id="conclusion" name="conclusion"
                                                      class="md-textarea form-control" rows="4" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="btn btn-brand" onclick="completeJob()">Submit</button>
                                    </div>
{{--                                </form>--}}
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Claim Description
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Description:</span> {{$job->description}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Service Type:</span> {{$job->service_type}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Claim Address
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">City:</span> {{$job->city}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Estate:</span> {{$job->estate}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Zip Code:</span> {{$job->zip_code}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Claim Details
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Policy No:</span> {{$job->policy_no}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Item Type:</span> {{$job->item_type}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Item Location:</span> {{$job->item_location}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Issue Details:</span> {{$job->issue_details}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Model No:</span> {{$job->model_no}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Serial No:</span> {{$job->serial_no}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Prior Issue:</span> {{$job->prior_issue}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Customer
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Name:</span> {{$customer->name}} </p>
                                    <p><span style="font-weight: 500">Email:</span> {{$customer->email}} </p>
                                    <p><span style="font-weight: 500">Phone No:</span> {{$customer->phone}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Customer Availability
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">First:</span> {{$job->customer_availability_one}} </p>
                                    <p><span style="font-weight: 500">Second:</span> {{$job->customer_availability_two}} </p>
                                    <p><span style="font-weight: 500">Third:</span> {{$job->customer_availability_three}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Attachments
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex flex-wrap">
                                        @if(count($jobImages) != 0)
                                            @foreach($jobImages as $images)
                                                <div style="margin-left: 10px">
                                                    <img style="object-fit: cover;border: 1px solid #a9a9a973;width: 200px;height: 200px;"
                                                         src="{{env('ADMIN_URL')}}/job-files/{{$images->image}}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No Images Attached</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Notes
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p> {{$job->notes}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 order-lg-6 order-xl-6">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand fas fa-briefcase"></i>
                            </span>
                                <h3 class="kt-portlet__head-title text-uppercase">
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
            // $(document).ready(function(){
            //     var maxDate = new Date(Date.now() + 62 * 60 * 60 * 1000).toISOString();
            //     elem = document.getElementById("sDate")
            //     var iso = new Date().toISOString();
            //     var minDate = iso.substring(0,iso.length-1);
            //     elem.min = minDate
            //     elem.max = maxDate
            //     console.log('min',minDate);
            //     console.log('max',maxDate);
            // });
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
                                "text": "Claim Status updated Successfully",
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
                                "text": "Claim started Successfully",
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
            if(document.getElementById('issueRepairedYes').checked === false && document.getElementById('issueRepairedNo').checked === false )
            {
                alert('Kindly select any issue repaired status!');
                return;
            }
            if(document.getElementById('conclusion').value === '')
            {
                alert('Kindly fill the conclusion!');
                return;
            }
            let data = new FormData();
            let issueRepaired = '';
            if (document.getElementById('issueRepairedYes').checked === true) {
                issueRepaired = 'Yes';
            }
            if (document.getElementById('issueRepairedNo').checked === true) {
                issueRepaired = 'No';
            }
            let conclusion = document.getElementById('conclusion').value;
            let jobId = document.getElementById('jobId').value;
            data.append("_token", "{{ csrf_token() }}");
            data.append("jobId", jobId);
            data.append("conclusion", conclusion);
            data.append("issueRepaired", issueRepaired);
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
                                "text": "Claim Completed Successfully",
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
