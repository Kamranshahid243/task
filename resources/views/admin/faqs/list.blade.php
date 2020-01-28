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

        <!-- <div class="box box-primary">
            <div class="box-body">
                <form class="form" action="{{ url('/admin/faqs/management') }}" method="post">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-lg btn-primary btn-flat">Go!</button>
                        </span>
                    </div>
                </form>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">View All FAQs</h3>
                        <a href="{{ url('/admin/faqs/management/create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>  <span>Create Faq</span></a>
                    </div>

                    <div class="box-body">
                        @if( $faqs->count() )
                            @foreach( $faqs as $i=>$faq )
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                    <h3 class="panel-title clearfix">
                                        <div class="auc-options-wrapper pull-right">
                                            <a href="{{ url('/admin/faqs/management/'.$faq->id.'/edit') }}" class="btn btn-xs btn-default" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a href="#" data-id="{{ $faq->id }}" data-url="{{ '/admin/faqs/management/'.$faq->id }}" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$faq->id}}" aria-expanded="false" aria-controls="collapse{{$faq->id}}">
                                        {{ 'Question #'.( $i+1 ).': '.$faq->question }}
                                        </a>
                                    </h3>
                                    </div>
                                    <div id="collapse{{$faq->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                           {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        @endif
                    </div>
                </div>            
            </div>
        </div>

        

    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form delete-form" method="post" action="">
                @method('DELETE')
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirmation!</h4>
                </div>
                <div class="modal-body">
                   <p><strong>Do you really want to delete this record?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form-btn"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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