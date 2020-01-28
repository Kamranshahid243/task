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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border"><h3 class="box-title">Notifications</h3></div>
                    <div class="box-body">

                        @if( !Auth::user()->notifications->count() )
                        <h4 class="alert text-danger">There are no notifications</h4>
                        @else
                        <ul class="timeline timeline-inverse">
                            
                            @php $trackingDate = null; @endphp

                            @foreach( Auth::user()->notifications as $notification )

                                @php $createdAt = date('j M, Y', strtotime( $notification->created_at) ); @endphp
                                
                                @if( $createdAt != $trackingDate )
                                  <!-- timeline time label -->
                                    <li class="time-label">
                                        <span class="bg-red">{{ $createdAt }}  </span>
                                    </li>
                                    @php $trackingDate = $createdAt; @endphp
                                    <!-- /.timeline-label -->
                                @endif 

                                 <!-- timeline item -->
                                <li class="notification-{{ $notification->id }}">
                                    <i class="{{ $notification->data['timeline_icon'] }}"></i>

                                    <div class="timeline-item clearfix">
                                        <a href="#" data-target="{{ $notification->id }}" class="auc-delete-notification time"><i class="fa fa-times"></i></a>
                                        <span class="time"><i class="fa fa-clock-o"></i> {{ $notification->created_at->diffForHumans() }}</span>
                                        
                                        @if( $notification->data['type'] == 'simple' )
                                        <div class="timeline-body">{!! $notification->data['message'] !!} </div>
                                        @elseif( $notification->data['type'] == 'simple-with-view-link' )
                                        <div class="timeline-body">{!! $notification->data['message'] !!}. <a href="{{ url( $notification->data['object_uri'] ) }}">View</a></div>
                                        @elseif( $notification->data['type'] == 'simple-with-description' )
                                        <h3 class="timeline-header">{!! $notification->data['message'] !!}</h3>
                                        <div class="timeline-body">{!! $notification->data['object_description'] !!}</div>
                                        @else
                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle quora plaxo ideeli hulu weebly balihoo...
                                        
                                            <div class="timeline-footer">
                                                <a class="btn btn-primary btn-xs">Read more</a>
                                                <a class="btn btn-danger btn-xs">Delete</a>
                                            </div>
                                        </div>
                                        @endif
                                    
                                </li>
                                <!-- END timeline item -->

                            @endforeach
                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                        @endif
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