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
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Reset Password</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/password/update') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label class="">Current Password</label>
                            <input type="password" class="form-control" name="cpassword" placeholder="Old Password">
                        </div>
                        <div class="form-group">
                            <label class="">New Password</label>
                            <input type="password" class="form-control" name="npassword" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label class="">Confirm Password</label>
                            <input type="password" class="form-control" name="cnpassword" placeholder="Confirm Password">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-primary pull-right form-btn">Reset Password</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>            
        </div>
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