<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
    <base href="../../../">
    <meta charset="utf-8"/>
    <title>Recover Password</title>
    <link rel="icon" href="https://cdn.landen.co/kr402kanl96f/assets/4r7y1qi3.png">
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{asset('css/pages/login/login-1.css')}}" rel="stylesheet">

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.bundle.css')}}" rel="stylesheet">


    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('css/skins/header/base/light.css')}}" rel="stylesheet">
    <link href="{{asset('css/skins/header/menu/light.css')}}" rel="stylesheet">
    <link href="{{asset('css/skins/brand/dark.css')}}" rel="stylesheet">
    <link href="{{asset('css/skins/aside/dark.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!--end::Layout Skins -->
    {{--    <link rel="shortcut icon" href=""/>--}}
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
        class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
        <div
                class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

            <!--begin::Aside-->
            <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside"
                 style="background-color: #f48134">
                <div class="kt-grid__item">
                    <a href="#" class="kt-login__logo">
                        {{--                    <img src="{{asset('media/logos/logo-4.png')}}">--}}
                    </a>
                </div>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <h3 class="kt-login__title">Recover Password!</h3>
                        <h4 class="kt-login__subtitle">The ultimate Service providing platform.</h4>
                    </div>
                </div>
                <div class="kt-grid__item">
                    <div class="kt-login__info">
                        {{--                        <div class="kt-login__copyright">--}}
                        {{--                            &copy 2018 Metronic--}}
                        {{--                        </div>--}}
                        <div class="kt-login__menu">
                            {{--                            <a href="#" class="kt-link">Privacy</a>--}}
                            {{--                            <a href="#" class="kt-link">Legal</a>--}}
                            {{--                            <a href="#" class="kt-link">Contact</a>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div
                    class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">
                <div class="kt-login__body">

                    <!--begin::Signin-->
                    <div class="kt-login__form">
                        <div class="kt-login__title">
                            <h3 style="font-weight: bold;color: black">Welcome back! Change your password.</h3>
                        </div>

                        <!--begin::Form-->
                        <div class="kt-form" novalidate="novalidate" id="kt_login_form">
                            <input type="hidden" value="{{$source ?? ''}}" id="sourceUrl">
                            <div class="form-group">
                                <input class="form-control" type="password" id="pass" name="password" placeholder="New Password" required>
                                <input value="{{$email}}" type="hidden" id="con-email">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" id="con-pass" name="password" placeholder="Re-Enter Password" required>
                                <input value="{{$email}}" type="hidden" id="con-email">
                            </div>
                            <!--begin::Action-->
                            <div class="kt-login__actions">
                                {{--                                <a href="#" class="kt-link kt-login__link-forgot">--}}
                                {{--                                    Forgot Password ?--}}
                                {{--                                </a>--}}
                                <button onclick="changePass()" id="kt_login_signin_submit"
                                        class="btn btn-brand btn-elevate kt-login__btn-primary btn-sm"
                                        >
                                    Change Password
                                </button>
                            </div>

                            <!--end::Action-->
                        </div>
                    </div>

                    <!--end::Signin-->
                </div>

                <!--end::Body-->
            </div>

            <!--end::Content-->
        </div>
    </div>
</div>

<!-- end:: Page -->

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

    function changePass() {
        var password = document.getElementById('pass').value;
        var conPass = document.getElementById('con-pass').value;
        var email = document.getElementById('con-email').value;
        if(password === '' || password.length < 6){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be 6 or more character long!',
            });
            return false;
        }
        if(password !== conPass){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Confirm password mismatched!',
            });
            return false;
        }
        let formData = new FormData();
        formData.append("password", password);
        formData.append("email", email);
        formData.append("_token", "{{ csrf_token() }}");
        $.ajax
        ({
            type: 'POST',
            url: `{{env('APP_URL')}}/forgot-password-change`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                if(data.status === true){
                    alert("Password updated successfully");
                    window.location.href = `{{env('APP_URL')}}`;
                }else{
                    alert(data.message);
                }
            },
            error: function (data) {
                alert(data.message);
                console.log("data", data.message);
            }
        });
    }
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script type="text/javascript"
        src="{{ \Illuminate\Support\Facades\URL::asset('plugins/global/plugins.bundle.js')}}"></script>
<script type="text/javascript" src="{{ \Illuminate\Support\Facades\URL::asset('js/scripts.bundle.js')}}"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
