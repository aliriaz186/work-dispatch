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
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Job Status
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($job->status == 'offered')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center" >{{$job->status}}</p>
                                        <button class="btn btn-success btn-sm" onclick="acceptJob()">Accept</button>
                                        <button class="btn btn-danger btn-sm">Reject</button>
                                    @endif
                                    @if($job->status == 'scheduled')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center" >{{$job->status}}</p>
                                        <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})</p>
                                        <p>Technician : {{$workerName}}</p>
                                    @endif
                                    @if($job->status == 'unscheduled')
                                        <p style="color: red; padding: 5px; border-radius: 10px; border: 1px solid red; width: 100px;text-align: center">{{$job->status}}</p>
                                        <p>Schedule the job</p>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p>Date</p>
                                                <input type="date" id="s-date">
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
                                            <button class="btn btn-primary btn-sm" style="margin-top: 10px" onclick="scheduleJob()">Schedule job</button>
                                        </div>
                                    @endif
                                        @if($job->status == 'On My Way')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Technician is on his way to job location!</p>
                                            <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}}
                                                - {{$schedule->est_time_to}})</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                        @if($job->status == 'Job Started')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Job Started</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                        @if($job->status == 'Completed')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Job Completed</p>
                                            <p>Technician : {{$workerName}}</p>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                   Job Description
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <p> {{$job->description}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p> {{$job->service_type}} </p>
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
                                    <p> {{$customer->name}} </p>
                                    <p> {{$customer->email}} </p>
                                    <p> {{$customer->phone}} </p>
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
                                    <p> {{$job->customer_availability_one}} </p>
                                    <p> {{$job->customer_availability_two}} </p>
                                    <p> {{$job->customer_availability_three}} </p>
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
                                    <p> Comming Soon </p>
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
                                    Job Location ({{$job->job_address}})
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
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    Activity of Job
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
                                "text": "Job Scheduled Successfully",
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
                                "text": "Accepted Successfully",
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
