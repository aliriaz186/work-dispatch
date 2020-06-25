<!-- begin:: Footer -->
{{--<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">--}}
{{--    <div class="kt-container  kt-container--fluid ">--}}
{{--        <div class="kt-footer__copyright">--}}
{{--            2019&nbsp;&copy;&nbsp;<a href="http://designerpex.com.au/" target="_blank" class="kt-link">Designer Pex</a>--}}
{{--        </div>--}}
{{--        <div class="kt-footer__menu">--}}
{{--            <a href="http://designerpex.com.au/" target="_blank" class="kt-footer__menu-link kt-link">Pricing Plans</a>--}}
{{--            <a href="http://designerpex.com.au/" target="_blank" class="kt-footer__menu-link kt-link">About</a>--}}
{{--            <a href="http://designerpex.com.au/" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- end:: Footer -->


<!-- end:: Page -->

<!-- begin::Quick Panel -->
<div id="kt_quick_panel" class="kt-quick-panel">
    <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
    <div class="kt-quick-panel__nav">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x"
            role="tablist">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_tab_notifications" role="tab">Notifications</a>
            </li>
        </ul>
    </div>
    <div class="kt-quick-panel__content">
        <div class="tab-content">
            <div class="tab-pane fade show kt-scroll active" id="kt_quick_panel_tab_notifications" role="tabpanel">
                <div class="kt-notification">
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-line-chart kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New order has been received
                            </div>
                            <div class="kt-notification__item-time">
                                2 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-box-1 kt-font-brand"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New customer is registered
                            </div>
                            <div class="kt-notification__item-time">
                                3 hrs ago
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop"><i class="fa fa-arrow-up"></i></div>
<!-- end::Scrolltop -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('plugins/custom/datatables/datatables.bundle.js')}}"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('js/pages/dashboard.js')}}"></script>
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('js/pages/crud/datatables/basic/scrollable.js')}}"></script>
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('js/pages/crud/forms/widgets/input-mask.js')}}"></script>
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('js/pages/crud/forms/widgets/bootstrap-select.js')}}"></script>
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('js/pages/crud/forms/validation/form-controls.js')}}"></script>


<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
