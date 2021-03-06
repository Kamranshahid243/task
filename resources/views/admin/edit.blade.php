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

   
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit User Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-verticle form" method="post" action="{{ url('/admin/users/management/'.$admin->id) }}">
                @csrf
                @method('PUT')
                <div class="box-body">
                   <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name<span class="text-red">*</span></label>
                                <input type="text" class="form-control" value="{{$admin->first_name }}" name="first_name" placeholder="First name">
                            </div>
                            <div class="form-group">
                                <label>Last Name<span class="text-red">*</span></label>
                                <input type="text" class="form-control" value="{{$admin->last_name }}" name="last_name" placeholder="Last name">
                            </div>
                            <div class="form-group">
                                <label >Email Address<span class="text-red">*</span></label>
                                <input type="text" class="form-control" value="{{$admin->email }}" name="email" placeholder="Email address">
                            </div>
                            <div class="form-group">
                                <label >Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" class="form-control" value="{{$admin->mobile }}" name="mobile" placeholder="Mobile number">
                            </div>
                            
                       </div>
                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone-number">Role<span class="text-red">*</span></label>
                                <select class="form-control" name="role_id">
                                    
                                    @if( $roles->count() )
                                        @foreach( $roles as $role )
                                            @if( $role->id == $admin->role_id)
                                            <option value="{{ $role->id }}" selected> {{ $role->name }} </option>
                                            @else
                                            <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone-number">Gender<span class="text-red">*</span></label>
                                <select class="form-control" name="gender_id">
                                    <option value="">Select gender </option>
                                    @if( $genders->count() )
                                        @foreach( $genders as $gender )
                                            
                                            <option value="{{ $gender->id }}" {{ ($gender->id == $admin->gender_id) ? 'selected':'' }}> {{ $gender->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Country</label>
                                <select class="form-control select2 country-list">
                                    @if( $countries->count() )
                                        <option value="">Select a country</option>
                                        @foreach( $countries as $country )
                                            <option value="{{ $country->id }}" {{ ($country->id == $admin->country_id) ? 'selected':'' }}> {{ $country->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group d-none states-wrapper">
                                <label for="">State</label>
                                <select  class="form-control  select2 state-list">
                                    @if( isset($admin->state ) )
                                    <option value="{{$admin->state->id }}">{{$admin->state->name }}</option>
                                    @else
                                    <option value="">Select State</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group d-none cities-wrapper">
                                <label for="">City</label>
                                <select  class="form-control  select2 city-list">
                                    @if( isset($admin->city ) )
                                    <option value="{{$admin->city->id }}">{{$admin->city->name }}</option>
                                    @else
                                    <option value="">Select City</option>
                                    @endif
                                </select>
                            </div>
                            

                            <input type="hidden" name="country_id" class="country-id">
                            <input type="hidden" name="state_id" class="state-id">
                            <input type="hidden" name="city_id" class="city-id">
                       </div>
                   </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    
                    <button type="submit" class="btn btn-primary pull-right form-btn">Save Changes</button>
                </div>
                <!-- /.box-footer -->
            </form>
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