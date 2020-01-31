@extends('layouts.master')

@section('title', $title)


@section('style-sheets')
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/skins/_all-skins.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
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
                            <h3 class="box-title">Edit Category</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-verticle form-with-attachment optional-attachment" method="post"
                              action="{{ url('/admin/categories/management/'.$found->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                @if( $found->thumbnail )
                                    <div class="auc-thumb-wrapper">
                                        <img class="" src="{{ asset( $found->thumbnail ) }}" alt="">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <img src="#" class="thumb-square-50x50" alt="" id="categoryImage" style="display: none">
                                    <label for="exampleInputFile">Thumbnail</label>
                                    <input type="file" id="inputCategory" class="auc-thumbnail" name="thumbnail">
                                    <br>
                                    <span><em>Valid thumbnail types are .jpg, jpeg, .png, .webp, .svg and .gif</em></span>
                                </div>
                                <div class="form-group">
                                    <label>Name<span class="text-red">*</span></label>
                                    <input type="text" class="form-control" value="{{ $found->name }}" name="name"
                                           placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label>Description<span class="text-red">*</span></label>
                                    <textarea type="text" class="form-control" name="description"
                                              placeholder="Description..."> {{ $found->description }} </textarea>
                                </div>
                                <div class="form-group">
                                    <label>Status<span class="text-red">*</span></label>
                                    <select class="form-control" name="status">
                                        @if( $found->is_paused )
                                            <option value="0">Hide</option>
                                            <option value="1">Show</option>
                                        @else
                                            <option value="1">Show</option>
                                            <option value="0">Hide</option>
                                        @endif


                                    </select>
                                    <span><em>The Hide status hides the category from website and Show does the opposite.</em></span>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">

                                <button type="submit" class="btn btn-primary pull-right form-btn"><i
                                        class="fa fa-check"></i> Save Changes
                                </button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box box-primary ">
                        <div class="box-header with-border">
                            <h3 class="box-title">View All Categories</h3>
                        </div>
                        <div class="box-body">
                            <table id="data-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Thumbnail</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Action<s/th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( isset( $categories ) and $categories->count() )
                                    @foreach( $categories as $category )
                                        <tr>
                                            <td><img class="thumb-square-50x50"
                                                     src="{{ asset( $category->thumbnail ) }}"></td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if( $category->is_paused == 1 )
                                                    <span class="label label-danger">Hide</span>
                                                @else
                                                    <span class="label label-success">Show</span>
                                                @endif
                                            </td>
                                            <td>{!! ( $category->created_by ) ? '<a href="'.url('/admin/users/management/'.$category->creator->id).'">'.$category->creator->first_name.' '.$category->creator->last_name.'</a>' : 'n/a' !!}</td>
                                            <td>{{ ( $category->created_at ) ? $category->created_at->toFormattedDateString() : 'n/a' }}</td>
                                            <td>
                                                <a href="{{ url('/admin/categories/management/'.$category->id.'/edit') }}"
                                                   title="Edit" data-action="edit" class="btn btn-xs btn-default"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="#" data-type="admin" data-id="{{ $category->id }}"
                                                   data-url="/admin/categories/management/{{$category->id}}"
                                                   title="Delete" data-action="delete"
                                                   class="custom-table-btn btn btn-xs btn-default"><i
                                                        class="fa fa-trash-o"></i></a>

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
                        <button type="submit" class="btn btn-primary form-btn"><i class="fa fa-trash"></i> Delete
                        </button>
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
                        <button type="submit" class="btn btn-primary form-btn"><i class="fa fa-check"></i> Unblock
                        </button>
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
            $('.sidebar-menu').tree();
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#categoryImage').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                    $('#categoryImage').css('display', "block");

                }
            }
            $("#inputCategory").change(function() {
                readURL(this);
            });
        })
    </script>
@endsection
