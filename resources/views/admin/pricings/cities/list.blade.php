@extends('layouts.master')

@section('title', $title) 


@section('style-sheets')
<link rel="stylesheet" href="{{ asset('/assets/dist/css/skins/_all-skins.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('/assets/bower_components/select2/dist/css/select2.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create City Level Pricing</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/cities/pricings') }}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label class="">Select a country<span class="text-red">*</span> </label>
                            <select class="form-control select2 country-list" name="country_id" placeholder="">
                                
                                @if( $countries->count() )
                                    <option value="">Select country to load states</option>
                                    @foreach( $countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        
                        </div>
                        <div class="form-group states-wrapper">
                            <label class="">Select a state<span class="text-red">*</span></label>
                            <select class="form-control select2 state-list" name="state_id" placeholder="">
                              
                            </select>
                            
                        </div>
                        <div class="form-group cities-wrapper">
                            <label class="">Select one or more cities<span class="text-red">*</span></label>
                            <select class="form-control select2 city-list" name="cities[]" multiple placeholder="">
                              
                            </select>
                            <span><em>You can select multiple cities to set the same price</em></span>
                        </div>
                        <div class="form-group">
                            <label class="">Price Per day<span class="text-red">*</span></label>
                            <input type="number" class="form-control" name="price_per_day" placeholder="Price Per Day">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                   
                        <button type="submit" class="btn btn-primary pull-right form-btn"><i class="fa fa-check"></i> Create</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>            
        </div>
        <div class="col-md-8">
            <div class="box box-primary ">
                <div class="box-header with-border">
                    <h3 class="box-title">View All Cities Pricings</h3>
                </div>
                <div class="box-body">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Price Per Day</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action<s/th>    
                            </tr>
                        </thead>
					<tbody>
                        @if( isset( $pricings ) and $pricings->count() )
                            @foreach( $pricings as $pricing )
                                <tr>
                                    <td>{{ $pricing->country->name }}</td>
                                    <td>{{ $pricing->state->name }}</td>
                                    <td>{{ $pricing->name }}</td>
                                    <td>{{ '$'.$pricing->price }}</td>
                                    <td>{{ $pricing->creator->first_name.' '.$pricing->creator->last_name }}</td>
                                    <td>{{ ( $pricing->created_at ) ? $pricing->created_at->toFormattedDateString() : 'n/a' }}</td>
                                    <td>
                                        <a href="{{ url('/admin/cities/pricings/'.$pricing->id.'/edit') }}"  title="Edit" data-action="edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></a> 
                                        <a href="#" data-type="admin" data-id="{{ $pricing->id }}" data-url="/admin/cities/pricings/{{$pricing->id}}"  title="Delete"data-action="delete" class="custom-table-btn btn btn-xs btn-default"><i class="fa fa-trash-o"></i></a>
                
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        
                    </tbody>
                
				</table>
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

<!-- Modal -->
<div class="modal fade block-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form block-form" method="post" action="">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirmation!</h4>
                </div>
                <div class="modal-body">
                   <p><strong>Do you really want to block this record?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form-btn"><i class="fa fa-ban"></i> Block</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div class="modal fade unblock-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" class="form unblock-form" method="post" action="">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Confirmation!</h4>
                </div>
                <div class="modal-body">
                   <p><strong>Do you really want to play this record?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary form-btn"><i class="fa fa-check"></i> Unblock</button>
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
<!-- DataTables -->
<script src="{{ asset('/assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
@endsection