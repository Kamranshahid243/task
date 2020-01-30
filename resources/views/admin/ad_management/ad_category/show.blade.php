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

                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua-active">
                        <h3 class="widget-user-username">{{$admin->first_name }} {{$admin->last_name }}</h3>
                        <h5 class="widget-user-desc">{{$admin->role->name }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="{{ asset( $admin->avatar ) }}" alt="User Avatar">
                    </div>
                    <div class="box-footer">
                
                        <div class="text-center">
                            <div class="description-block">
                                <h5 class="description-header">{{ $admin->created_at->toFormattedDateString() }}</h5>
                                <span class="description-text">JOINED SINCE</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                </div>

              
   
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <!-- form start -->
                        <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                    @if( $admin->deleted_at )
                                    <div class="form-group">
                                        <label>Deleted At</label>
                                        <p class="form-control font-weight-bold bg-red text-white">{{$admin->deleted_at->toDayDateTimeString() }}</p>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <label>Last Updated</label>
                                        <p class="form-control font-weight-bold bg-gray">{{$admin->updated_at->toDayDateTimeString() }}</p>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <p class="form-control">{{$admin->first_name }}"</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <p class="form-control">{{$admin->last_name }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label >Email Address</label>
                                        <p class="form-control">{{$admin->email }}</p>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <p class="form-control">{{$admin->mobile }}</p>
                                    </div>
                                    
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-number">Role</label>
                                        <p class="form-control">{{$admin->role->name }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone-number">Gender</label>
                                        <p class="form-control">{{$admin->gender->name }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <p class="form-control">{{ $admin->country_id ?  $admin->country->name : 'n/a' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">State</label>
                                        <p class="form-control">{{ $admin->state_id ?  $admin->state->name : 'n/a' }}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <p class="form-control">{{ $admin->city_id ?  $admin->city->name : 'n/a' }}</p>
                                    </div>
                                
                            </div>
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