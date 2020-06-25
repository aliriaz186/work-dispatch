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
                                    Job Status
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($job->status == 'scheduled')
                                        <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">{{$job->status}}</p>
                                        <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})</p>
                                    <p>Change status</p>
                                        <button class="btn btn-primary" onclick="onMyWay()">On my Way</button>
                                    @endif
                                        @if($job->status == 'On My Way')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">You are on your way!</p>
                                            <p>Schedule on {{$schedule->date}} between ({{$schedule->est_time_from}}
                                                - {{$schedule->est_time_to}})</p>
                                            <p>Change status</p>
                                            <button class="btn btn-primary" onclick="startJob()">Start Job</button>
                                        @endif
                                        @if($job->status == 'Job Started')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Job Started!</p>
                                            <p>Change status</p>
                                            <button class="btn btn-primary" onclick="completeJob()">Complete Job</button>
                                        @endif
                                        @if($job->status == 'Completed')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">Job Completed!</p>
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
