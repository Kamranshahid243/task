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
                    <h3 class="box-title">Terms & Conditions</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/terms') }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Terms & Conditions</label>
                                    <textarea name="terms_and_conditions" id="editor1" rows="10" cols="80">@if(isset($term))
                                            {{$policy}}
                                        @endif
                                </textarea>
                                    <script>

                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace('editor1');
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right form-btn"><i class="fa fa-check"></i>
                            Save Changes
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Privacy Policy</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/terms') }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Privacy Policy</label>
                                    <textarea name="privacy_policy" id="editor2" rows="10" cols="80">  @if(isset($term))
                                            {{$term}}
                                        @endif

                                </textarea> <script>

                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace('editor2');
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right form-btn"><i class="fa fa-check"></i>
                            Save Changes
                        </button>
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
