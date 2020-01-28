@extends('layouts.master')

@section('title', $title) 


@section('style-sheets')
<link rel="stylesheet" href="{{ asset('/assets/dist/css/skins/_all-skins.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/assets/bower_components/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

         <!-- Content Wrapper. Contains page content -->

         <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 1126px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1></h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-4">
                <div class="box box-primary ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Login Approval Code</h3>
                    </div>

                <form class="form" method="post" action="{{ url('/admin/security/login/approval/code/'.(Auth::user()->is_login_approval_code_on ? 'disable' : 'enable')) }}">
                    @csrf
                    <div class="box-body min-height-170px">
                        @if( Auth::user()->is_login_approval_code_on )
                        <h4 class="font-weight-bolder">Current Status: <span class="text-italic text-success">Enabled</span></h4>
                        <p>If you disable login approval code, our system will not automatically send you a login approval code when you try to  login to your account.</p>
                        @else
                        <h4 class="font-weight-bolder">Current Status: <span class="text-italic text-danger">Disabled</span></h4>
                        <p>If you enable login approval code, our system will automatically send you a login approval code when you try to  login to your account.</p>
                        @endif
                        
                    </div>
                    <div class="box-footer">
                        @if( !Auth::user()->is_login_approval_code_on )
                        <button type="submit" class="btn btn-primary pull-right form-btn">Enable</button>
                        @else
                        <button type="submit" class="btn btn-danger pull-right form-btn">Disable</button>
                        @endif
                    </div>
                </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary ">
                    <div class="box-header with-border">
                        <h3 class="box-title">OTP (One Time Password)</h3>
                    </div>

                    <form class="form" method="post" action="{{ url('/admin/security/otp/'.(Auth::user()->is_login_otp_on ? 'disable' : 'enable')) }}">
                        <div class="box-body min-height-170px">
                            @if( Auth::user()->is_login_otp_on )
                            <h4 class="font-weight-bolder">Current Status: <span class="text-italic text-success">Enabled</span></h4>
                            <p>If you disable OTP (One Time Password), our system will not send you a temporary password on your email.</p>
                            @else
                            <h4 class="font-weight-bolder">Current Status: <span class="text-italic  text-danger">Disabled</span></h4>
                            <p>If you enable OTP (One Time Password), our system will automatically send you a temporary password on your email. Everytime you login, you will get a new password.</p>
                            @endif
                        </div>
                        <div class="box-footer">
                            @if( Auth::user()->is_login_otp_on )
                            <button type="submit" class="btn btn-danger pull-right form-btn">Disable</button>
                            @else
                            <button type="submit" class="btn btn-primary pull-right form-btn">Enable</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-primary ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Password Expiry</h3>
                    </div>

                    <form class="form" method="post" action="{{ url('/admin/security/password/expiry/'.(Auth::user()->is_login_password_expiry_on ? 'disable' : 'enable')) }}">
                        <div class="box-body min-height-170px {{ auth()->user()->is_login_password_expiry_on ? 'auc-login-password-expiry' : '' }}">
                            @if( Auth::user()->is_login_password_expiry_on )
                            <h4 class="font-weight-bolder">Current Status: <span class="text-italic text-success">Enabled</span></h4>
                            <p>If you disable this setting, your password will not expire anymore.</p>
                            @else
                            <h4 class="font-weight-bolder">Current Status: <span class="text-italic text-danger">Disabled</span></h4>
                            <p>If you enable this setting, you will be able to set a password expiry duration in seconds, minutes and hours.</p>
                            
                            
                            <div class="auc-form-wrapper auc-profile-form-wrapper mt-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="time-unit">Select Time Unit</label>
                                            <select name="time_unit" class="form-control custom-select rounded-0" id="time-unit">
                                                <option value="">Select a time unit</option>
                                                <option value="seconds">Seconds</option>
                                                <option value="minutes">Minutes</option>
                                                <option value="hours">Hours</option>
                                                <option value="days">Days</option>
                                            </select>
                                        </div>
                                    
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="duration">Duration</label>
                                            <input type="number" class="form-control rounded-0" name="duration" placeholder="Duration" id="duration">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="box-footer">
                            @if( Auth::user()->is_login_password_expiry_on )
                            <button type="submit" class="btn btn-danger pull-right">Disable</button>
                            @else
                            <button type="submit" class="btn btn-primary pull-right">Enable</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.col -->
        </div>

    </section>
    <!-- /.content -->
</div>
@endsection

@section('scripts')
<script src="{{ asset('/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('/assets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/assets/dist/js/demo.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('/assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
@endsection