@extends('dashboard/layout')
@section('content')
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <!--Begin::Dashboard 1-->

        <!--Begin::Row-->
        <div class="row">
            <div class="col-xl-12 order-lg-12 order-xl-12">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head kt-portlet__head--lg">
                        <div class="kt-portlet__head-label">
							<span class="kt-portlet__head-icon">
                                <i class="fas fa-file-invoice"></i>
							</span>
                            <h3 class="kt-portlet__head-title">
                                Invoices
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <div class="kt-portlet__head-actions">
                                    <div class="dropdown dropdown-inline">
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="kt-nav">
                                                <li class="kt-nav__section kt-nav__section--first">
                                                    <span class="kt-nav__section-text">Choose an option</span>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-print"></i>
                                                        <span class="kt-nav__link-text">Print</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-copy"></i>
                                                        <span class="kt-nav__link-text">Copy</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                        <span class="kt-nav__link-text">Excel</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                        <span class="kt-nav__link-text">CSV</span>
                                                    </a>
                                                </li>
                                                <li class="kt-nav__item">
                                                    <a href="#" class="kt-nav__link">
                                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                        <span class="kt-nav__link-text">PDF</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="{{env('APP_URL')}}/invoice/new"
                                       class="btn btn-brand btn-elevate btn-icon-sm">
                                        <i class="la la-plus"></i>
                                        Create New Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable"
                               id="technician-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td><a target="_blank" href="{{asset('new-invoices')}}/{{$item->invoice}}"><img style="padding:20px;object-fit: cover;border: 1px solid #a9a9a973;width: 200px;height: 200px;" alt="Click to Open"
                                             src="{{asset('new-invoices')}}/{{$item->invoice}}"></a></td>
                                    <td>
                                        <select name="invoiceStatus" id="invoiceStatus"
                                                class="form-control" value="{{$item->status ?? ''}}">
                                            <option  {{$item->status == "open" ? 'selected' : ''}} value="open">Open</option>
                                            <option  {{$item->status == "closed" ? 'selected' : ''}} value="closed">Closed</option>
                                        </select>
                                        <div>
                                            <p style="text-decoration: underline;color: blue;padding-top: 10px;float: right;cursor: pointer" onclick="changeInvoiceStatus({{$item->id}})">Update</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!--end: Datatable -->
                    </div>

                    <!-- Model -->
                </div>

            </div>
        </div>
        <!--End::Row-->

        <!--End::Dashboard 1-->
    </div>

    <!-- end:: Content -->
    <script>
        function changeInvoiceStatus(invoiceId)
        {
            KTApp.blockPage({
                baseZ: 2000,
                overlayColor: '#000000',
                type: 'v1',
                state: 'danger',
                opacity: 0.15,
                message: 'Processing...'
            });
            var invoiceStatus = document.getElementById('invoiceStatus').value;

            let formData = new FormData();
            formData.append("invoiceId", invoiceId);
            formData.append("invoiceStatus", invoiceStatus);
            formData.append("_token", "{{ csrf_token() }}");
            $.ajax
            ({
                type: 'POST',
                url: `{{env('APP_URL')}}/job/invoice/status/change`,
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
                            "text": "Updated Successfully",
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
        }
    </script>
@endsection
