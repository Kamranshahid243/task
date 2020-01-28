@extends('layouts.auth')

@section('title', $title)

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/admin') }}"><b>Admin</b><br>Forgot Password</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

        <form class="form" action="{{ url('/admin/password/email') }}" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat form-btn">Send Password Reset Link</button>
        </form>
        <br>
      
        
    </div>
    <p class="auth-box-footer">Don't want to reset? <a href="{{ url('/admin') }}">Click here</a></p>
    <!-- /.login-box-body -->
</div>
@endsection