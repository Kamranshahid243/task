@extends('layouts.auth')

@section('title', $title)

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/admin') }}"><b>Admin</b><br>Reset Password</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <form class="form" action="{{ url('/admin/password/reset') }}" method="post">
            <input type="hidden" name="token" value="{{ $token }}">    
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat form-btn">Reset Password</button>
        </form>
        <br>
      
        
    </div>
    <p class="auth-box-footer">Don't want to reset? <a href="{{ url('/admin') }}">Click here</a></p>
    <!-- /.login-box-body -->
</div>
@endsection