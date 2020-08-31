@extends('dashboard.layout')
<!-- begin:: Content -->
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <form action="#" method="POST" id="listing_form" class="form-horizontal listing_form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xl-12 order-lg-12 order-xl-12">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="kt-font-brand fas fa-user"></i>
                            </span>
                                <h3 class="kt-portlet__head-title">
                                    New Technician
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="Enter full name">
                                </div>
                                <div class="col-lg-4">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-envelope"></i></span></div>
                                        <input type="text" name="email" id="email"
                                               class="form-control"
                                               placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i
                                                    class="fa fa-phone"></i></span></div>
                                        <input type="text" name="phone" id="phone"
                                               class="form-control"
                                               placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <label>Type of work <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="row col-lg-12 mt-1">
                                            <input id="plumbing-work" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Plumbing</span>
                                            <input id="electrician-work" style="margin-left: 129px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Electrician</span>
                                            <input id="hvac-work" style="margin-left: 139px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Hvac</span>
                                        </div>
                                        <div class="row col-lg-12 mt-1">
                                            <input id="garage-doors-work" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Garage Doors</span>
                                            <input id="appliances-work" style="margin-left: 100px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Appliances</span>
                                            <input id="drywall-work" style="margin-left: 133px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Drywall</span>
                                        </div>
                                        <div class="row col-lg-12 mt-1">
                                            <input id="roof-repair-work" style="" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Roof Repair</span>
                                            <input id="septic-system-work" style="margin-left: 117px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Septic System</span>
                                            <input id="pools-work" style="margin-left: 114px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Pools</span>
                                        </div>
                                        <div class="row col-lg-12 mt-1">
                                            <input id="central-vacuum-work" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">Central Vacuum</span>
                                            <input id="other-work" style="margin-left: 85px" type="checkbox"><span style="margin-top: -3px;margin-left: 6px;">other</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-brand">Save</button>
                                        |
                                        <a href="{{env('APP_URL')}}/workers" class="btn btn-warning" style="background-color: #0780b7;border-color: #0780b7;color: white;">Go Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- end:: Content -->
    <script>
        let checkBoxesArray = [];
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
                                checkBoxesArray = [];
                            }
                        })
                    },
                    // Here we submit the completed form to database
                    submitHandler: function (form, e) {
                        // Enable Page Loading
                        if (document.getElementById('other-work').checked === false && document.getElementById('central-vacuum-work').checked === false && document.getElementById('pools-work').checked === false && document.getElementById('septic-system-work').checked === false && document.getElementById('roof-repair-work').checked === false && document.getElementById('drywall-work').checked === false && document.getElementById('appliances-work').checked === false && document.getElementById('garage-doors-work').checked === false && document.getElementById('hvac-work').checked === false && document.getElementById('electrician-work').checked === false && document.getElementById('plumbing-work').checked === false) {
                            swal.fire({
                                "title": "",
                                "text": "Please select atleast one work type",
                                "type": "error",
                                "confirmButtonClass": "btn btn-secondary",
                                "onClose": function (e) {
                                    console.log('on close event fired!');
                                }
                            })
                            event.preventDefault();
                            return;
                        }
                        if(document.getElementById('plumbing-work').checked === true)
                        {
                            checkBoxesArray.push('Plumbing');
                        }
                        if(document.getElementById('electrician-work').checked === true)
                        {
                            checkBoxesArray.push('Electrician');
                        }
                        if(document.getElementById('hvac-work').checked === true)
                        {
                            checkBoxesArray.push('Hvac');
                        }
                        if(document.getElementById('garage-doors-work').checked === true)
                        {
                            checkBoxesArray.push('Garage Doors');
                        }
                        if(document.getElementById('appliances-work').checked === true)
                        {
                            checkBoxesArray.push('Appliances');
                        }
                        if(document.getElementById('drywall-work').checked === true)
                        {
                            checkBoxesArray.push('Drywall');
                        }
                        if(document.getElementById('roof-repair-work').checked === true)
                        {
                            checkBoxesArray.push('Roof Repair');
                        }
                        if(document.getElementById('septic-system-work').checked === true)
                        {
                            checkBoxesArray.push('Septic System');
                        }
                        if(document.getElementById('pools-work').checked === true)
                        {
                            checkBoxesArray.push('Pools');
                        }
                        if(document.getElementById('central-vacuum-work').checked === true)
                        {
                            checkBoxesArray.push('Central Vacuum');
                        }
                        if(document.getElementById('other-work').checked === true)
                        {
                            checkBoxesArray.push('Other');
                        }
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
                        data.push({
                            "name": "checkBoxesArray",
                            "value": checkBoxesArray
                        });
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        $.ajax({
                            url: "{{env('APP_URL')}}/workers/save",
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
                                                window.location.href = `{{env('APP_URL')}}/workers`
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
