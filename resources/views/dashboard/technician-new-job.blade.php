@extends('dashboard.layout')
<!-- begin:: Content -->
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <form action="#" method="POST" id="listing_form" class="form-horizontal listing_form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xl-4 order-lg-4 order-xl-4">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand fas fa-briefcase"></i>
                            </span>
                                <h3 class="kt-portlet__head-title">
                                    New Job => {{$technician->name}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="col-lg-12">
                                <label>Job Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-map-marker-alt"></i></span></div>
                                    <input type="text" name="address" id="address"
                                           class="form-control" placeholder="Enter address" onchange="addressEntered(this.value)">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Technician <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-user"></i></span></div>
                                    <input type="text" name="technician_name" id="technician_name"
                                           class="form-control" placeholder="Select technician from map" readonly value="{{$technician->name}}">
                                    <input type="text" name="technician_id" id="technician_id"
                                           class="form-control" style="display: none" value="{{$technician->id}}">
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2" style="margin-top: 20px !important;">
                                <label class="">Job Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="Enter job title">
                            </div>
                            <div class="col-lg-12 mt-2" style="margin-top: 20px !important;">
                                <label class="">Job Description <span class="text-danger">*</span></label>
                                <input type="text" name="description" id="description" class="form-control"
                                       placeholder="Enter job description">
                            </div>
                            <div class="col-lg-12 mt-2" style="margin-top: 20px !important;">
                                <label class="">Job Service Type <span class="text-danger">*</span></label>
                                <input type="text" name="service_type" id="service_type" class="form-control"
                                       placeholder="Enter job service type">
                            </div>
                            <div class="col-lg-12 mt-2" style="margin-top: 20px !important;">
                                <label class="">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="Enter full name">
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Customer Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-envelope"></i></span></div>
                                    <input type="text" name="email" id="email"
                                           class="form-control"
                                           placeholder="Enter email">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Customer Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-phone"></i></span></div>
                                    <input type="text" name="phone" id="phone"
                                           class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Customer Availability</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-calendar-times"></i></span></div>
                                    <input type="datetime-local" name="customer_availability_one" id="customer_availability_one"
                                           class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Next Best Availability</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-calendar-times"></i></span></div>
                                    <input type="datetime-local" name="customer_availability_one" id="customer_availability_one"
                                           class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Third Best Availability</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-calendar-times"></i></span></div>
                                    <input type="datetime-local" name="customer_availability_one" id="customer_availability_one"
                                           class="form-control"
                                           placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px !important;">
                                <label>Notes</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-sticky-note"></i></span></div>
                                    <input type="text" name="notes" id="notes"
                                           class="form-control"
                                           placeholder="enter notes (optional)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary">Create Job</button>
                                        |
                                        <a href="{{env('APP_URL')}}/technicians/{{$technician->id}}/details" class="btn btn-warning">Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-8 order-lg-8 order-xl-8">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand fas fa-map"></i>
                            </span>
                                <h3 class="kt-portlet__head-title">
                                    Select address of job
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div id="map" style="height:825px !important;width:100%;"></div>

                            <input type="hidden" id="lat" name="lat" value=""/>
                            <input type="hidden" id="longg" name="longg" value=""/>
                        </div>
                    </div>
                </div>
                <img src="{{asset('img/technician.png')}}" style="display: none" id="technician-icon">
            </div>
        </form>
        <p id="tec-long" style="display: none">{{$technician->longg}}</p>
        <p id="tec-lat" style="display: none">{{$technician->lat}}</p>
        <p id="tec-name" style="display: none">{{$technician->name}}</p>
        <script>
            var marker = false; ////Has the user plotted their location marker?
            var lati = 25.785257;
            var longi = -80.221207;
            var map, infoWindow, geocoder;
            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {lat: lati, lng: longi}
                });
                getTechnicianMarkerts();

                geocoder = new google.maps.Geocoder;
                infoWindow = new google.maps.InfoWindow;


                google.maps.event.addListener(map, 'click', function(event) {
                    //Get the location that the user clicked.
                    var clickedLocation = event.latLng;
                    //If the marker hasn't been added.
                    if(marker === false){
                        //Create the marker.
                        marker = new google.maps.Marker({
                            position: clickedLocation,
                            map: map,
                            draggable: true //make it draggable
                        });
                        //Listen for drag events!
                        google.maps.event.addListener(marker, 'dragend', function(event){
                            markerLocation();
                        });
                    } else{
                        //Marker has already been added, so just change its location.
                        marker.setPosition(clickedLocation);

                    }
                    //Get the marker's location.
                    markerLocation();
                });
            }

            function geocodeLatLng(geocoder, map, infowindow) {

            }
            function moveToLocation(lat, lng){
                var center = new google.maps.LatLng(lat, lng);
                map.panTo(center);
            }

            function markerLocation(){
                //Get location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                var newlat = currentLocation.lat(); //latitude
                var newlong = currentLocation.lng(); //longitude
                document.getElementById('lat').value = newlat;
                document.getElementById('longg').value = newlong;
                console.log(newlong);
                console.log(newlat);
                var myurl = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +newlat+ "," +newlong+"&key=AIzaSyBiWCqUwYcKgZyvusgkFOKfop1vA2dLZnE";
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function(e) {
                    if (this.readyState === 4 && this.status === 200) {
                        let data = JSON.parse(e.srcElement.response);
                        var dat = JSON.stringify(data.results);
                        console.log(data);
                        var address= data.results[1].formatted_address;
                        document.getElementById('address').value = address;
                    }
                };
                xhttp.open("GET", myurl, true);
                xhttp.send();

            }

            function addressEntered(address){
                // alert(address);
                // if (geocoder) {
                //     geocoder.geocode( { 'address': address}, function(results, status) {
                //         if (status === google.maps.GeocoderStatus.OK) {
                //             if (status !== google.maps.GeocoderStatus.ZERO_RESULTS) {
                //                 map.setCenter(results[0].geometry.location);
                //                 var infowindow = new google.maps.InfoWindow(
                //                     { content: '<b>'+address+'</b>',
                //                         size: new google.maps.Size(150,50)
                //                     });
                //
                //                 var marker = new google.maps.Marker({
                //                     position: results[0].geometry.location,
                //                     map: map,
                //                     title:address
                //                 });
                //                 google.maps.event.addListener(marker, 'click', function() {
                //                     infowindow.open(map,marker);
                //                 });
                //
                //             } else {
                //                 alert("No results found");
                //             }
                //         } else {
                //             alert("Geocode was not successful for the following reason: " + status);
                //         }
                //     });
                // }
            }

            function getTechnicianMarkerts() {
                    var myLatLng = {lat: parseFloat(document.getElementById('tec-lat').innerText)  , lng: parseFloat(document.getElementById('tec-long').innerText)};
                    var mymarker = new google.maps.Marker({
                        position: myLatLng,
                        title:document.getElementById('tec-name').innerText,
                        icon: document.getElementById('technician-icon').getAttribute('src'),
                    });
                    mymarker.setMap(map);
                document.getElementById('technician_name').value=document.getElementById('tec-name').innerText;
            }

        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJqJcwaHOlWKivApYFYSjmVobGeKFqGdE&callback=initMap">
        </script>
    </div>
    <script>

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
            }, 3000);

            $(function () {
                // Initialize form validation.
                $(".listing_form").validate({
                    // Specify validation rules
                    rules: {
                        address: {required: true},
                        technician_name: {required: true},
                        title: {required: true},
                        description: {required: true},
                        service_type: {required: true},
                        name: {required: true},
                        email: {email: true, required: true},
                        phone: {required: true, minlength: 10},

                    },
                    // Specify validation error messages
                    messages: {
                        address: "Please enter address",
                        technician_name: "Please select technician from map",
                        title: "Please enter title",
                        description: "Please enter description",
                        service_type: "Please enter service type",
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
                            url: "{{env('APP_URL')}}/job/save",
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
                                                window.location.href = `{{env('APP_URL')}}/jobs`
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
