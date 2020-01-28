@extends('layouts.auth')

@section('title', $title)

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/admin') }}"><b>Admin</b> Login</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        @if( session('login_notification_message') )
        <div class="alert alert-info">{{  session('login_notification_message')  }}</div>
        @endif
        <form class="form" action="{{ url('/admin/login') }}" method="post">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if( session('code_sent') )
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="login_approval_code" placeholder="Login Approval Code">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @endif
            <button type="submit" class="btn btn-primary btn-block btn-flat form-btn">Sign In</button>
        </form>
        <br>
        
        
    </div>
    <p class="auth-box-footer text-center">Forgot password? <a href="{{ url('/admin/password/reset') }}">Click here</a></p>
    <!-- /.login-box-body -->
</div>
@endsection