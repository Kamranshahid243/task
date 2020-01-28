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
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ asset( Auth::user()->avatar) }}" alt="User profile picture">

              <h3 class="profile-username text-center">Nina Mcintire</h3>

              <p class="text-muted text-center">Super Admin</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Full Name</b> <a class="pull-right">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                </li>
                <li class="list-group-item">
                  <b>Email Address</b> <a class="pull-right">{{ Auth::user()->email }}</a>
                </li>
                <li class="list-group-item">
                  <b>Mobile#</b> <a class="pull-right">{{ Auth::user()->phone ? Auth::user()->phone : 'n/a' }}</a>
                </li>
                <li class="list-group-item">
                  <b>Gender</b> <a class="pull-right">{{ Auth::user()->gender->name }}</a>
                </li>
                <li class="list-group-item">
                  <b>Location</b> <a class="pull-right">
                  {{ ( Auth::user()->country_id AND Auth::user()->state_id AND Auth::user()->country_id) ? Auth::user()->city->name.', '.Auth::user()->state->name.', '.Auth::user()->country->name : 'n/a' }} 
                 
                  </a>
                </li>
              </ul>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
         
              <li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
              <li><a href="#settings" data-toggle="tab">Edit Profile</a></li>
            </ul>
            <div class="tab-content">
    
              <!-- /.tab-pane -->
              <div class="active tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal form" method="post" action="{{ url('/admin/profile/update') }}">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" name="first_name" value="{{ Auth::user()->first_name }}" placeholder="First Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputlName" class="col-sm-2 control-label">Last Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="last_name"  value="{{ Auth::user()->last_name }}"   id="inputlName" placeholder="Last Name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputlName" class="col-sm-2 control-label">Last Name</label>
                      <div class="col-sm-10">
                        <select class="form-control" name="gender_id">
                          <option value="{{ Auth::user()->gender_id }}"> {{ Auth::user()->gender->name }} </option>
                            @if( $genders->count() )
                                @foreach( $genders as $gender )
                                    @if( Auth::user()->gender_id != $gender->id )
                                    <option value="{{ $gender->id }}"> {{ $gender->name }} </option>
                                    @endif
                                @endforeach
                            @endif
                        </select>  
                      </div>
                  </div>   

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control"  name="email"  value="{{ Auth::user()->email }}"  id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputMobile" class="col-sm-2 control-label">Mobile</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="mobile" value="{{ Auth::user()->mobile }}"  id="inputMobile" placeholder="Mobile">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Country</label>

                    <div class="col-sm-10">
                        <select class="form-control select2 country-list">
                          <option value="">Select Country</option>
                          @if( $countries )
                            @foreach( $countries as $country )
                              @if( $country->id == Auth::user()->country_id )
                              <option value="{{ $country->id }}" selected> {{ $country->name }} </option>
                              @else
                              <option value="{{ $country->id }}"> {{ $country->name }} </option>
                              @endif
                            @endforeach
                          @endif
                        </select>
                    </div>
                  </div>

                  <div class="form-group {{ isset(Auth::user()->state) ? '': 'd-none' }} states-wrapper">
                    <label for="" class="col-sm-2 control-label">State</label>

                    <div class="col-sm-10">
                        <select class="form-control select2 state-list">
                           @if( isset( Auth::user()->state ) )
                           <option value="{{ Auth::user()->state->id }}">{{ Auth::user()->state->name }}</option>
                           @else
                           <option value="">Select State</option>
                           @endif
                        </select>
                    </div>
                  </div>

                  <div class="form-group {{ isset(Auth::user()->city) ? '': 'd-none' }} cities-wrapper">
                    <label for="" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
                        <select class="form-control select2 city-list">
                           @if( isset( Auth::user()->city ) )
                           <option value="{{ Auth::user()->city->id }}">{{ Auth::user()->city->name }}</option>
                           @else
                           <option value="">Select City</option>
                           @endif
                        </select>
                    </div>
                  </div>
                  <input type="hidden" name="country_id" value="{{ Auth::user()->country_id }}" class="country-id">
                  <input type="hidden" name="state_id" value="{{ Auth::user()->state_id }}" class="state-id">
                  <input type="hidden" name="city_id" value="{{ Auth::user()->city_id }}" class="city-id">

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary form-btn">Save Changes</button>
                    </div>
                  </div>
              </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

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