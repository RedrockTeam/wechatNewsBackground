<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="@yield('description')" name="description" />
    <meta content="@yield('author')" name="author" />
    @yield('extra-meta')
    <title>@yield('page-title')</title>
    {{-- Font Resources ============ --}}
    @section('web-font')
        @include('vendor.metronic.assets.font')
    @show
    @yield('plugins-css')
    {{-- Theme Stylesheets ============ --}}
    @section('theme-css')
        <link href="{{ URL::asset('assets/css/metronic/global/components.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ URL::asset('assets/css/metronic/global/plugins.css') }}" rel="stylesheet" type="text/css" />
    @show

    @section('layout-css')
        <link href="{{ URL::asset('assets/css/vendor/bootstrap/bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/metronic/theme.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/css/vendor/bootstrap-switch/bootstrap-switch.css') }}" rel="stylesheet" type="text/css" />
    @show

    {{-- Fav ICON ============ --}}
    @section('favicon')
        <link rel="shortcut icon" href="favicon.ico" />
    @show
</head>
    <body class="@yield('body-class')">
    {{-- Page Header include top-menu ============ --}}
            @yield('header')
            @section('container')
                 {{-- Sidebar include search form and main nav ============ --}}
                @yield('sidebar')
                {{-- Content include main content ============ --}}
                @yield('content')
                {{-- Footer include website copyright ============ --}}
                @yield('footer')
            @show
            {{-- Quick Sidebar include user info ============ --}}
            @yield('quick-sidebar')

     <!--[if lt IE 9]>
    <script src="../assets/global/plugins/respond.min.js"></script>
    <script src="../assets/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    {{-- Layout Scripts ============ --}}
    @section('layout-js')
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ URL::asset('assets/js/vendor/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/vendor/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/vendor/jquery-bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/vendor/blockUI/jquery.blockUI.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/vendor/bootstrap-switch/bootstrap-switch.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
    @show
    {{-- Plugin Scripts ============ --}}
    @yield('plugins-js')
    {{-- Theme Scripts ============ --}}
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ URL::asset('assets/js/metronic/app.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    @yield('theme-js')
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ URL::asset('assets/js/metronic/layouts/layout.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/js/metronic/layouts/quick-sidebar.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->

    </body>
    </html>
