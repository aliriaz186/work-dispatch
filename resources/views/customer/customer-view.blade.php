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
                            <div class="kt-portlet__head-label" style="padding: 20px">
                                <ul class="stepper stepper-horizontal" style="list-style: none;">
                                  @if($job->status == "offered" || $job->status == "unscheduled" || $job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                    <li class="completed" style="text-decoration: none!important;">
                                            <h3 class="kt-portlet__head-title text-uppercase">
                                                <i class="fas fa-check-circle" style="color: green; font-size: 18px"></i> Job Created
                                            </h3>
                                        <p style="padding-left: 20px; margin-top: 20px">
                                            your job has been created in {{env('APP_NAME')}}
                                        </p>
                                    </li>
                                   @endif
                                   @if($job->status == "scheduled" || $job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                          <li class="completed" style="text-decoration: none!important;">
                                              <h3 class="kt-portlet__head-title text-uppercase">
                                                  <i class="fas fa-check-circle" style="color: green; font-size: 18px"></i>  Job Scheduled
                                              </h3>
                                              <p style="padding-left: 20px; margin-top: 20px">
                                                  your job has been scheduled on {{$schedule->date}} between ({{$schedule->est_time_from}} - {{$schedule->est_time_to}})
                                              </p>
                                              <p style="padding-left: 20px; margin-top: 20px">
                                                  Technician : {{$worker->name}} ({{$worker->phone}})
                                              </p>
                                          </li>
                                   @endif
                                   @if($job->status == "On My Way" || $job->status == "Job Started" || $job->status == "Completed")
                                          <li class="completed" style="text-decoration: none!important;">
                                              <h3 class="kt-portlet__head-title text-uppercase">
                                                  <i class="fas fa-check-circle" style="color: green; font-size: 18px"></i>  Technician On its way
                                              </h3>
                                              <p style="padding-left: 20px; margin-top: 20px">
                                                  Technician is on its way, He will be at your location shortly.
                                              </p>
                                          </li>
                                   @endif
                                   @if($job->status == "Job Started" || $job->status == "Completed")
                                          <li class="completed" style="text-decoration: none!important;">
                                              <h3 class="kt-portlet__head-title text-uppercase">
                                                  <i class="fas fa-check-circle" style="color: green; font-size: 18px"></i>  Job Started
                                              </h3>
                                              <p style="padding-left: 20px; margin-top: 20px">
                                                  Technician started the job
                                              </p>
                                          </li>
                                   @endif
                                   @if($job->status == "Completed")
                                          <li class="completed" style="text-decoration: none!important;">
                                              <h3 class="kt-portlet__head-title text-uppercase">
                                                  <i class="fas fa-check-circle" style="color: green; font-size: 18px"></i>  Job Completed
                                              </h3>
                                              <p style="padding-left: 20px; margin-top: 20px">
                                                  Technician completed the job
                                              </p>
                                              <p style="padding-left: 20px; margin-top: 20px" >Reviews</p>
                                          </li>
                                   @endif


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <p id="long" style="display: none">{{$job->long}}</p>
        <p id="lat" style="display: none">{{$job->lat}}</p>
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
