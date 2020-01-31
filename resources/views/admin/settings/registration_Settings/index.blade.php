@extends('layouts.master')

@section('title', $title)

@push('head-scripts')
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
@endpush
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
                    <h3 class="box-title">Registration Fields</h3>
                </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-10">
                                <form runat="server">
                                    <input type='file' id="imgInp" />
                                    <img id="blah" src="#" alt="your image" />
                                </form>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                @if(isset($data))
                                    @foreach($data as $rec)
                                            <tr>
                                        <td>{{$rec->name}}</td>
                                        @if($rec->is_disabled)
                                            <td><span class="label label-danger">Disabled</span> </td>
                                                @else
                                            <td><span class="label label-success">Enabled</span> </td>
                                        @endif
                                        <td>@if($rec->created_by) {{$rec->creator->first_name.' '.$rec->creator->last_name}}@endif</td>
                                        @if(!$rec->is_disabled)
                                            <td>
                                                <a href="#" data-type="admin" data-id="{{ $rec->id }}" data-url="/admin/registration-setting/{{$rec->id}}"  title="Delete"data-action="delete" class="custom-table-btn btn btn-xs btn-default"><i class="fa fa-check"></i></a>
                                            </td>
                                        @else
                                            <td> <a href="#" data-type="admin" data-id="{{ $rec->id }}" data-url="/admin/registration-setting/{{$rec->id}}"  title="Disable"data-action="delete" class="custom-table-btn btn btn-xs btn-default"><i class="fa fa-ban"></i></a></td>
                                        @endif
                                    </tr> @endforeach
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
    <div class="modal fade delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" class="form delete-form" method="post" action="">
                    @method('put')
                    <div class="modal-header modal-header-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Confirmation!</h4>
                    </div>
                    <div class="modal-body">
                        <p><strong>Do you really want to update this record?</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button  type="submit" class="btn btn-primary form-btn"><i class="fa fa-trash"></i> Yes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
