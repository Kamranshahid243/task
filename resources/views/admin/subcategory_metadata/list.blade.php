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
                            <h3 class="box-title">Create Subcategory Metadata</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-verticle form" method="post" action="{{ url('/admin/subcategories/metadata/') }}">
                            @method('post')
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Select category<span class="text-red">*</span></label>
                                    <select class="form-control select2" name="category_id">
                                        @if( $categories->count() )
                                            @foreach( $categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Subcategory<span class="text-red">*</span></label>
                                    <select class="form-control select2" name="sub_category_id">
                                        @if( $subcategories->count() )
                                            @foreach( $subcategories as $subcategory )
                                                    <option value="{{ $subcategory->id }}" >{{ $subcategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Name<span class="text-red">*</span></label>
                                    <input type="text" class="form-control" name="key">
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">

                                <button type="submit" class="btn btn-primary pull-right form-btn"><i class="fa fa-check"></i> Save </button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box box-primary ">
                        <div class="box-header with-border">
                            <h3 class="box-title">View All Subcategories Metadata</h3>
                        </div>
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( isset( $subcategories_metadata ) and $subcategories_metadata->count() )
                                    @foreach( $subcategories_metadata as $subcategory_meta )
                                        <tr>
                                            <td>{{ $subcategory_meta->key }}</td>
                                            <td>{{ $subcategory_meta->category->name }}</td>
                                            <td>{{ $subcategory_meta->subCategory->name }}</td>
                                            <td>{{$subcategory_meta->creator->first_name.' '.$subcategory_meta->creator->last_name}}</td>
                                            <td>{{ ( $subcategory_meta->created_at ) ? $subcategory_meta->created_at->toFormattedDateString() : 'n/a' }}</td>
                                            <td>
                                                <a href="{{ url('/admin/subcategories/metadata/'.$subcategory_meta->id.'/edit') }}"  title="Edit" data-action="edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i></a>
                                                <a href="#" data-type="admin" data-id="{{ $subcategory_meta->id }}" data-url="/admin/subcategories/metadata/{{$subcategory_meta->id}}"  title="Delete"data-action="delete" class="custom-table-btn btn btn-xs btn-default"><i class="fa fa-trash-o"></i></a>

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
