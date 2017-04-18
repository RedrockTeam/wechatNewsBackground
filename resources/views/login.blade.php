 @extends('vendor.metronic.assets.global')
        @section('page-title', '管理员登陆')
        @section('plugins-css')
            <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
            <link href="{{ URL::asset('assets/css/vendor/bootstrap-switch/bootstrap-switch.css') }}" rel="stylesheet" type="text/css" />
            <link href="{{URL::asset('assets/css/metronic/pages/login-5.css')}}" rel="stylesheet" type="text/css" />
        @stop

    @section('body-class', 'login')
    @section('container')
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset">
                    <div class="login-bg" style="background-image:url({{URL::asset('assets/img/login/bg1.jpg')}})">
                        {{--<img class="login-logo" src="{{URL::asset('assets/img/login/logo.png')}}" /> --}}
                    </div>
                </div>

                <div class="col-md-6 login-container bs-reset">
                    <div class="login-content">
                        <h1>管理员登录</h1>
                        <form action="javascript:;" class="login-form" method="post">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <span>Enter any username and password. </span>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Username" name="username" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" required/> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    {{--<a class="btn yellow" type="submit">注册</a>--}}
                                </div>
                                <div class="col-sm-8 text-right">
                                    <button class="btn green" type="submit">登陆</button>
                                </div>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
        @stop
        @section('plugins-js')
        <script src="{{URL::asset('assets/js/vendor/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/plugins/backstretch/jquery.backstretch.min.js')}}" type="text/javascript"></script>
        @stop

        @section('theme-js')
            <script src="{{URL::asset('assets/js/login/login-5.js')}}" type="text/javascript"></script>
            <script>
                $('.login-bg').backstretch([
                    "{{URL::asset('assets/img/login/bg1.jpg')}}",
                    "{{URL::asset('assets/img/login/bg2.jpg')}}",
                    "{{URL::asset('assets/img/login/bg3.jpg')}}"
                    ], {
                        fade: 1000,
                        duration: 8000
                    }
                );
            </script>
        @stop
