@extends('dashboard.layout')
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
                                        @foreach($ratings as $item)
                                            <div class="col-lg-12">
                                                <p><span
                                                        style="font-weight: 500">Rating:</span> {{$item->rating}} out of
                                                    5
                                                </p>
                                            </div>
                                            <div class="col-lg-12">
                                                <p><span
                                                        style="font-weight: 500">Additional Comments:</span> {{$item->additional_comments}}
                                                </p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-lg-12">
                                            <p>No reviews yet!</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
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
                                    @if($job->status == 'offered')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center" >{{$job->status}}</p>
                                        <button class="btn btn-brand btn-sm" onclick="acceptJob()">Accept</button>
                                        <button class="btn btn-danger btn-sm" style="background-color: #0780b7;border-color: #0780b7;color: white;" onclick="rejectJob()">Reject</button>
                                    @endif
                                    @if($job->status == 'scheduled')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center" >{{$job->status}}</p>
                                        <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})</p>
                                        <p>Technician : {{$workerName}}</p>
                                    @endif
                                    @if($job->status == 'unscheduled')
                                        <p style="color: red; padding: 5px; border-radius: 10px; border: 1px solid red; width: 100px;text-align: center">{{$job->status}}</p>
                                        <p>Schedule the claim</p>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p>Date</p>
                                                <input type="text" id="s-date" placeholder="Select date" onclick="disablingDateField()">
                                            </div>
                                            <div class="col-lg-3">
                                                <p>EST From</p>
                                                <input type="time" id="s-start-time">
                                            </div>
                                            <div class="col-lg-3">
                                                <p>EST To</p>
                                                <input type="time" id="s-end-time">
                                            </div>
                                        </div>
                                        <p style="margin-top: 20px">Select Worker/Technician</p>
                                        <select id="selected-worker">
                                            <option value="">Select worker...</option>
                                            @foreach($workers as $worker)
                                            <option value="{{$worker->id}}">{{$worker->name}}</option>
                                             @endforeach
                                        </select>
                                        <div>
                                            <button class="btn btn-brand btn-sm" style="margin-top: 10px" onclick="scheduleJob()">Schedule Claim</button>
                                        </div>
                                    @endif
                                        @if($job->status == 'On My Way')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Technician is on his way to Claim location!</p>
                                            <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}}
                                                - {{$schedule->est_time_to}})</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                        @if($job->status == 'Job Started')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Claim Started</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                        @if($job->status == 'Completed')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Claim Completed</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                        @if($job->status == 'rejected')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Claim Rejected</p>
{{--                                            <p>Technician : {{$workerName}}</p>--}}
                                        @endif
                                </div>
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
                                    Claim Location
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p> {{$job->job_address}} </p>
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
{{--                                    <p><span style="font-weight: 500">Third:</span> {{$job->customer_availability_three}} </p>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Providers
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Name:</span> {{$technician->name}} </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Email:</span> {{$technician->email}} </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Phone:</span> {{$technician->phone}} </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Address:</span> {{$technician->address}} </p>
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
                    <div class="kt-portlet kt-portlet--mobile" style="display: none">
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
                    <div class="kt-portlet kt-portlet--mobile" style="display: none">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Activity of Claim
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p> Comming Soon </p>
                                </div>
                            </div>
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
        window.onload = (event) => {
            $(document).ready(function () {
                const today = new Date()
                const tomorrow = new Date(today)
                tomorrow.setDate(tomorrow.getDate() + 2)
                $('#s-date').datepicker('setStartDate', new Date());
                $('#s-date').datepicker('setEndDate', tomorrow);
            });
        };
        // function disablingDateField() {
        //     $(document).ready(function () {
        //         const today = new Date()
        //         const tomorrow = new Date(today)
        //         tomorrow.setDate(tomorrow.getDate() + 1)
        //         $('#s-date').datepicker('setStartDate', new Date());
        //         $('#s-date').datepicker('setEndDate', tomorrow);
        //     });
        // }

        function scheduleJob() {
            let date = document.getElementById('s-date').value;
            let startTime = document.getElementById('s-start-time').value;
            let endTime = document.getElementById('s-end-time').value;
            let selectedWorker = document.getElementById('selected-worker').value;
            if (date === '' || date === undefined){
                swal.fire({
                    "title": "",
                    "text": "Invalid Date",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                });
                return;
            }
            if (startTime === '' || startTime === undefined){
                swal.fire({
                    "title": "",
                    "text": "Invalid EST Start",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                });
                return;
            }
            if (endTime === '' || endTime === undefined){
                swal.fire({
                    "title": "",
                    "text": "Invalid EST End",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                });
                return;
            }
            if (selectedWorker === '' || selectedWorker === undefined){
                swal.fire({
                    "title": "",
                    "text": "Please select worker",
                    "type": "error",
                    "confirmButtonClass": "btn btn-secondary",
                });
                return;
            }
            let data = new FormData();
            let jobId = document.getElementById('jobId').value;
            data.append("_token", "{{ csrf_token() }}");
            data.append("jobId", jobId);
            data.append("date", date);
            data.append("estStart", startTime);
            data.append("estEnd", endTime);
            data.append("selectedWorker", selectedWorker);
            KTApp.blockPage({
                baseZ: 2000,
                overlayColor: '#000000',
                type: 'v1',
                state: 'danger',
                opacity: 0.15,
                message: 'Processing...'
            });
            $.ajax({
                url: "{{env('APP_URL')}}/job/schedule",
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
                                "text": "Claim Scheduled Successfully",
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

        function acceptJob(){
            let data = new FormData();
            let jobId = document.getElementById('jobId').value;
            console.log(jobId)
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
                url: "{{env('APP_URL')}}/job/accept",
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
                                "text": "Claim Accepted Successfully",
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

        function rejectJob(){
            let data = new FormData();
            let jobId = document.getElementById('jobId').value;
            console.log(jobId)
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
                url: "{{env('APP_URL')}}/job/reject",
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
                                "text": "Claim Rejected Successfully",
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

        $(document).ready(function () {
            KTApp.blockPage({
                baseZ: 2000,
                overlayColor: '#000000',
                type: 'v1',
                state: 'danger',
                opacity: 0.15,
                message: 'Loading Please Wait...'
            });
            setTimeout(function () {
                KTApp.unblockPage();
            }, 2000);

            $(function () {
                // Initialize form validation.
                $(".listing_form").validate({
                    // Specify validation rules
                    rules: {
                        name: {required: true},
                        email: {email: true, required: true},
                        phone: {required: true, minlength: 10},

                    },
                    // Specify validation error messages
                    messages: {
                        name: "Please enter name",
                        email: "Please enter email address",
                        phone: {
                            required: "Please provide a phone number",
                            minlength: "Your phone number must be 10 characters long"
                        },
                    },
                    // Invalid Handler message
                    invalidHandler: function (event, validator) {
                        swal.fire({
                            "title": "",
                            "text": "There are some errors in your submission. Please correct them.",
                            "type": "error",
                            "confirmButtonClass": "btn btn-secondary",
                            "onClose": function (e) {
                                console.log('on close event fired!');
                            }
                        })
                    },
                    // Here we submit the completed form to database
                    submitHandler: function (form, e) {
                        // Enable Page Loading
                        KTApp.blockPage({
                            baseZ: 2000,
                            overlayColor: '#000000',
                            type: 'v1',
                            state: 'danger',
                            opacity: 0.15,
                            message: 'Processing...'
                        });
                        var form = $('.listing_form');
                        var data = form.serializeArray();
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        $.ajax({
                            url: "{{env('APP_URL')}}/customer/update",
                            type: 'POST',
                            dataType: "JSON",
                            data: data,
                            success: function (result) {
                                if (result['status']) {
                                    // Disable Page Loading and show confirmation
                                    setTimeout(function () {
                                        KTApp.unblockPage();
                                    }, 1000);
                                    setTimeout(function () {
                                        swal.fire({
                                            "title": "",
                                            "text": "Saved Successfully",
                                            "type": "success",
                                            "showConfirmButton": false,
                                            "timer": 1500,
                                            "onClose": function (e) {
                                                window.location.href = `{{env('APP_URL')}}/customers`
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
                });
            });

        });

    </script>
@endsection
