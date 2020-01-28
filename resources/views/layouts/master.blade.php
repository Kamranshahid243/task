<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ $title?? '' }}</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/AdminLTE.min.css') }}">
    @yield('style-sheets')
    <!-- Dashboard style -->
    <link rel="stylesheet" href="{{ asset('/assets/css/dashboard.min.css?v='.time()) }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
    @include('layouts.master-ng-app')
    @yield('head-scripts')

</head>
<body class="{{ $bodyClass?? '' }}" ng-app="myApp" ng-controller="LayoutController">


    @auth('admin')
    <div class="wrapper" style="height: auto; min-height: 100%;">



        @if( !isset($sidebar) )
            @include('includes.admin.topbar')
            @include('includes.admin.sidebar')
        @endif



        @yield('content')


        <footer class="main-footer">
            <div class="pull-right hidden-xs">

            </div>
            <strong>Developed by <a href="http://aucsol.com"> AUCSOL</a></strong>
        </footer>


        @include('includes.admin.theme-switcher-sidebar')

    </div>
    @endauth

    @guest('admin')
        @yield('content')
    @endguest


    <!-- jQuery 3 -->
    <script src="{{ asset('/assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}" ></script>

    @yield('scripts')
    <!-- Dashboard -->
    <script src="{{ asset('/assets/js/dashboard.min.js?v='.time()) }}"></script>
</body>
</html>
