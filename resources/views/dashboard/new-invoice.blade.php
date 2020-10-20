@extends('dashboard.layout')
<!-- begin:: Content -->
@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <form action="{{url('new/invoice/save')}}" enctype='multipart/form-data' method="POST" class="form-horizontal listing_form">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xl-12 order-lg-12 order-xl-12">
                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="fas fa-file-invoice"></i>
                            </span>
                                <h3 class="kt-portlet__head-title">
                                    New Invoice
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="offer-images">Select file to upload: </label>
                                    <div class="input-group">
                                        <input id="offerImages" type="file" name="images[]"
                                               multiple/>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="offer-images">Select Job ID: </label>
                                    <div class="input-group">
                                        <select name="jobId" id="jobId"
                                                class="form-control">
                                            @foreach($jobId as $item)
                                                <option value="{{$item->id}}">{{$item->id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        |
                                        <a href="{{env('APP_URL')}}/invoices" class="btn btn-warning">Go Back</a>
                                    </div>
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
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            KTApp.blockPage({--}}
{{--                baseZ: 2000,--}}
{{--                overlayColor: '#000000',--}}
{{--                type: 'v1',--}}
{{--                state: 'danger',--}}
{{--                opacity: 0.15,--}}
{{--                message: 'Loading Please Wait...'--}}
{{--            });--}}
{{--            setTimeout(function () {--}}
{{--                KTApp.unblockPage();--}}
{{--            }, 3000);--}}
{{--            $(function () {--}}
{{--                alert('hi');--}}

{{--                // Initialize form validation.--}}
{{--                $(".listing_form").validate({--}}
{{--                    // Specify validation rules--}}
{{--                    rules: {--}}
{{--                        // name: {required: true},--}}
{{--                        // email: {email: true, required: true},--}}
{{--                        // phone: {required: true, minlength: 10},--}}
{{--                        // address: {required: true},--}}
{{--                        // website: {required: true},--}}

{{--                    },--}}
{{--                    // Specify validation error messages--}}
{{--                    messages: {--}}
{{--                        // name: "Please enter name",--}}
{{--                        // email: "Please enter email address",--}}
{{--                        // phone: {--}}
{{--                        //     required: "Please provide a phone number",--}}
{{--                        //     minlength: "Your phone number must be 10 characters long"--}}
{{--                        // },--}}
{{--                        // address: "Please enter address",--}}
{{--                        // website: "Please enter address",--}}
{{--                    },--}}
{{--                    // Invalid Handler message--}}
{{--                    invalidHandler: function (event, validator) {--}}
{{--                        swal.fire({--}}
{{--                            "title": "",--}}
{{--                            "text": "There are some errors in your submission. Please correct them.",--}}
{{--                            "type": "error",--}}
{{--                            "confirmButtonClass": "btn btn-secondary",--}}
{{--                            "onClose": function (e) {--}}
{{--                            }--}}
{{--                        })--}}
{{--                    },--}}
{{--                    // Here we submit the completed form to database--}}
{{--                    submitHandler: function (form, e) {--}}

{{--                        // Enable Page Loading--}}
{{--                        KTApp.blockPage({--}}
{{--                            baseZ: 2000,--}}
{{--                            overlayColor: '#000000',--}}
{{--                            type: 'v1',--}}
{{--                            state: 'danger',--}}
{{--                            opacity: 0.15,--}}
{{--                            message: 'Processing...'--}}
{{--                        });--}}
{{--                        var form = $('.listing_form');--}}
{{--                        var data = form.serializeArray();--}}
{{--                        data.push({--}}
{{--                            "name": "invoice",--}}
{{--                            "value": document.getElementById('offer-images').file[0]--}}
{{--                        });--}}
{{--                        data.push({--}}
{{--                            "name": "jobId",--}}
{{--                            "value": document.getElementById('jobId').value--}}
{{--                        });--}}
{{--                        e.preventDefault();--}}
{{--                        e.stopImmediatePropagation();--}}
{{--                        alert('bye');--}}

{{--                        $.ajax({--}}
{{--                            url: "{{env('APP_URL')}}/new/invoice/save",--}}
{{--                            type: 'POST',--}}
{{--                            dataType: "JSON",--}}
{{--                            data: data,--}}
{{--                            success: function (result) {--}}
{{--                                if (result['status']) {--}}
{{--                                    // Disable Page Loading and show confirmation--}}
{{--                                    setTimeout(function () {--}}
{{--                                        KTApp.unblockPage();--}}
{{--                                    }, 1000);--}}
{{--                                    setTimeout(function () {--}}
{{--                                        swal.fire({--}}
{{--                                            "title": "",--}}
{{--                                            "text": "Saved Successfully",--}}
{{--                                            "type": "success",--}}
{{--                                            "showConfirmButton": false,--}}
{{--                                            "timer": 1500,--}}
{{--                                            "onClose": function (e) {--}}
{{--                                                window.location.href = `{{env('APP_URL')}}/invoices`--}}
{{--                                            }--}}
{{--                                        })--}}
{{--                                    }, 2000);--}}
{{--                                } else {--}}
{{--                                    setTimeout(function () {--}}
{{--                                        KTApp.unblockPage();--}}
{{--                                    }, 1000);--}}
{{--                                    setTimeout(function () {--}}
{{--                                        swal.fire({--}}
{{--                                            "title": "",--}}
{{--                                            "text": result['message'],--}}
{{--                                            "type": "error",--}}
{{--                                            "confirmButtonClass": "btn btn-secondary",--}}
{{--                                            "onClose": function (e) {--}}
{{--                                                console.log('on close event fired!');--}}
{{--                                            }--}}
{{--                                        })--}}
{{--                                    }, 2000);--}}
{{--                                }--}}
{{--                            }--}}
{{--                        });--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--        });--}}

{{--    </script>--}}
@endsection
