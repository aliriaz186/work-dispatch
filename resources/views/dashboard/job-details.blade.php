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
                                <h3 class="kt-portlet__head-title text-uppercase">
                                    <span style="font-weight: 500">Claim No:</span> {{$job->id}}
                                </h3>
                            </div>
                        </div>
                    </div>
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
                                        Attach Invoice
                                    </h3>
                                </div>
                            </div>
                            @if(!\App\JobInvoices::where('job_id', $job->id)->exists())
                            <div class="kt-portlet__body">
                                <div class="row">
                                    <label for="offer-images">Select file to upload: </label>
                                    <div class="input-group">
                                        <input id="offer-images" onclick="selectImages()" type="file" name="images[]"
                                               multiple/>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div style="margin-left: 10px">
                                    <a target="_blank" href="{{asset('new-invoices')}}/{{\App\JobInvoices::where('job_id', $job->id)->first()['invoice']}}">
                                    <img style="padding:20px;object-fit: cover;border: 1px solid #a9a9a973;width: 200px;height: 200px;" alt="Click to Open"
                                         src="{{asset('new-invoices')}}/{{\App\JobInvoices::where('job_id', $job->id)->first()['invoice']}}"></a>
                                </div>
                            @endif
                        </div>
                    @endif
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
                                    @if(count($ratings) != 0)
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
                                        <button class="btn btn-danger btn-sm" style="background-color: #0780b7;border-color: #0780b7;color: white;" data-toggle="modal" data-target="#exampleModal">Reject</button>
                                    @endif
                                        @if($job->status == 'scheduled')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 100px;text-align: center">{{$job->status}}</p>
                                            @if(\App\ClaimRescheduleNotHome::where('job_id', $job->id)->exists())
                                                <p>We missed you, and will try you again on {{$schedule->date}} between
                                                    ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})</p>
                                            @else
                                                <p>Schedule on {{$schedule->date}} between ({{date("h:i A", strtotime($schedule->est_time_from)) ?? ''}}
                                                    - {{date("h:i A", strtotime($schedule->est_time_to)) ?? ''}})</p>
                                            @endif
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
                                            <button class="btn btn-brand btn-sm" style="margin-top: 10px" data-toggle="modal" data-target="#modalContactForm">+ Add Technician</button>
                                        </div>
                                    @endif
                                        @if($job->status == 'On My Way')
                                            <p style="color: green; padding: 5px; border-radius: 10px; border: 1px solid green; width: 150px;text-align: center">
                                                Technician is on his way to Claim location!</p>
                                            <p>Schedule on {{$schedule->date}} between ({{date("h:i A", strtotime($schedule->est_time_from)) ?? ''}}
                                                - {{date("h:i A", strtotime($schedule->est_time_to)) ?? ''}})</p>
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
                                        @endif
                                        @if(\App\DispatchJob::where('id', $job->id)->first()['status'] == 'Follow Up')
                                            <h6>Claim was Follow Up</h6>
                                            <p><span style="font-weight: 500">Reason:</span> {{$followUp->reason}} </p>
                                            <h5>--Awaiting response from Priority Home Warranty--</h5>
                                            <a style="text-decoration: underline;text-align: center" href="tel:8888121060">Click to Call Admin Office</a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h3 class="kt-portlet__head-title">
                                        New Technician
                                    </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="#" method="POST" id="listing_form1" class="form-horizontal listing_form1">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xl-12 order-lg-12 order-xl-12">
                                            <div class="kt-portlet kt-portlet--mobile">
                                                <div class="kt-portlet__body">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <label class="">Full Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" id="name"
                                                                   class="form-control"
                                                                   placeholder="Enter full name">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label>Email <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fa fa-envelope"></i></span></div>
                                                                <input type="text" name="email" id="email"
                                                                       class="form-control"
                                                                       placeholder="Enter email">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label>Phone <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend"><span
                                                                        class="input-group-text"><i
                                                                            class="fa fa-phone"></i></span></div>
                                                                <input type="text" name="phone" id="phone"
                                                                       class="form-control"
                                                                       placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-lg-12">
                                                            <label>Type of work <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="row col-lg-12 mt-1">
                                                                    <input id="plumbing-work" type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Plumbing</span>
                                                                    <input id="electrician-work"
                                                                           style="margin-left: 129px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Electrician</span>
                                                                    <input id="hvac-work" style="margin-left: 139px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Hvac</span>
                                                                </div>
                                                                <div class="row col-lg-12 mt-1">
                                                                    <input id="garage-doors-work" type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Garage Doors</span>
                                                                    <input id="appliances-work"
                                                                           style="margin-left: 100px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Appliances</span>
                                                                    <input id="drywall-work" style="margin-left: 133px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Drywall</span>
                                                                </div>
                                                                <div class="row col-lg-12 mt-1">
                                                                    <input id="roof-repair-work" style=""
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Roof Repair</span>
                                                                    <input id="septic-system-work"
                                                                           style="margin-left: 117px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Septic System</span>
                                                                    <input id="pools-work" style="margin-left: 114px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Pools</span>
                                                                </div>
                                                                <div class="row col-lg-12 mt-1">
                                                                    <input id="central-vacuum-work"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">Central Vacuum</span>
                                                                    <input id="other-work" style="margin-left: 85px"
                                                                           type="checkbox"><span
                                                                        style="margin-top: -3px;margin-left: 6px;">other</span>
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
                                                                <button type="submit" class="btn btn-brand">Save
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </form>
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
                                    <p><span style="font-weight: 500">Location:</span> {{$job->job_address}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">City:</span> {{$job->city}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">State:</span> {{$job->estate}} </p>
                                </div>
                                <div class="col-lg-12">
                                    <p><span style="font-weight: 500">Zip Code:</span> {{$job->zip_code}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile" style="display: none">
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
                                    <p><span style="font-weight: 500">First:</span>
                                        @if(!empty($job->customer_availability_one))
                                        {{date('Y-m-d h:i A', strtotime($job->customer_availability_one)) ?? ''}}
                                            @endif
                                    </p>
                                    <p><span style="font-weight: 500">Second:</span>
                                        @if(!empty($job->customer_availability_two))
                                        {{date('Y-m-d h:i A', strtotime($job->customer_availability_two)) ?? ''}}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet kt-portlet--mobile" style="display: none">
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

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Claim Denied</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <p><span style="font-weight: 500">Reason:</span></p>
                                <input class="form-control" id="deniedReason" name="deniedReason">
                                <ul id="reason" class="small" style="color: red;display: none"><li>Reason cannot be null</li></ul>
                            </div>
                            <div class="mt-3">
                                <p><span style="font-weight: 500">Message For Customer:</span></p>
                                <input class="form-control" id="customerMessage" name="customerMessage">
                                <ul id="message" class="small" style="color: red;display: none"><li>Message cannot be null</li></ul>
                            </div>
                            <div>
                                <button type="button" id="send-email-btn" class="btn btn-success"
                                        style="background-color: #0780b7!important;border-color: #0780b7;color: white;margin-top: 15px;border: none!important;" onclick="rejectJob()">Submit
                                </button>
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

    <script type="text/javascript">
        function selectImages() {
            if (window.File && window.FileList && window.FileReader) {
                var filesInput = document.getElementById("offer-images");

                filesInput.addEventListener("change", function (event) {
                    var files = [];
                    files = event.target.files; //FileList object
                    var output = document.getElementById("result");
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];

                        //Only pics
                        if (!file.type.match('image'))
                            continue;

                        var picReader = new FileReader();

                        picReader.addEventListener("load", function (event) {

                            var picFile = event.target;

                            var div = document.createElement("span");

                            div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                                "title='" + picFile.name + "'/>";

                            output.insertBefore(div, null);

                        });

                        //Read the image
                        picReader.readAsDataURL(file);
                    }
                    KTApp.blockPage({
                        baseZ: 2000,
                        overlayColor: '#000000',
                        type: 'v1',
                        state: 'danger',
                        opacity: 0.15,
                        message: 'Processing...'
                    });
                    var offerImages = document.getElementById('offer-images').files;

                    let formData = new FormData();
                    for (var i = 0; i < offerImages.length; i++) {
                        formData.append("offer_images[]", offerImages[i]);
                    }
                    let jobId = document.getElementById('jobId').value;
                    formData.append("jobId", jobId);
                    formData.append("_token", "{{ csrf_token() }}");
                    $.ajax
                    ({
                        type: 'POST',
                        url: `{{env('APP_URL')}}/job/invoice/save`,
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
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
                                        setTimeout(function () {
                                            KTApp.unblockPage();
                                        }, 1000);
                                        window.location.reload();
                                    }
                                })
                            }, 2000);
                        },
                        error: function (data) {
                            checkBoxesArray = [];
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
                    });

                });
            } else {
                console.log("Your browser does not support File API");
            }
        }</script>

    <script>
        window.onload = (event) => {
            $(document).ready(function () {
                const today = new Date();
                const tomorrow = new Date(today);
                var today1 = new Date();
                var day = today1.getDay();
                var daylist = ["Sunday", "Monday", "Tuesday", "Wednesday ", "Thursday", "Friday", "Saturday"];
                if (daylist[day] === 'Friday') {
                    tomorrow.setDate(tomorrow.getDate() + 3)
                    $('#s-date').datepicker('setStartDate', new Date());
                    $('#s-date').datepicker('setEndDate', tomorrow);
                }
                tomorrow.setDate(tomorrow.getDate() + 2)
                $('#s-date').datepicker('setStartDate', new Date());
                $('#s-date').datepicker('setEndDate', tomorrow);
            });
        };

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
            document.getElementById('reason').style.display = 'none';
            document.getElementById('message').style.display = 'none';
            if(document.getElementById('deniedReason').value === '' || document.getElementById('deniedReason').value === null)
            {
                document.getElementById('reason').style.display = 'block';
                return;
            }
            if(document.getElementById('customerMessage').value === '' || document.getElementById('customerMessage').value === null)
            {
                document.getElementById('message').style.display = 'block';
                return;
            }
            let data = new FormData();
            let jobId = document.getElementById('jobId').value;
            let deniedReason = document.getElementById('deniedReason').value;
            let customerMessage = document.getElementById('customerMessage').value;
            console.log(jobId)
            data.append("_token", "{{ csrf_token() }}");
            data.append("jobId", jobId);
            data.append("deniedReason", deniedReason);
            data.append("customerMessage", customerMessage);
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
                $(".listing_form1").validate({
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
                        var form = $('.listing_form1');
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
                });
            });

        });

    </script>
@endsection
