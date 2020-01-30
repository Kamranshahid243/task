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
                    <h3 class="box-title">Create Ad Category</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/ad-categories') }}">
                    @csrf
                    <div class="box-body">

                        <div class="row content">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name<span class="text-red">*</span></label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nickname<span class="text-red">*</span></label>
                                    <input type="text" name="nickname" class="form-control">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>title<span class="text-red">*</span></label>
                                        <input type="text" name="title" class="form-control">
                                    </div>

                                </div>
                                <div class="col-md-6">   <div class="form-group">
                                        <label>Description<span class="text-red">*</span></label>
                                        <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right form-btn"><i class="fa fa-check"></i>
                            Create
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>


        </section>
        <!-- /.content -->
    </div>
    <style>
        ul li {
            float: left;
            margin-left: 1em;
            color: red;
        }

        ul {
            list-style: none;
        }
    </style>
@endsection

@section('scripts')
    <script>
        var adminVar = document.getElementById('adminVariable');
        var customerVar = document.getElementById('customerVariable');
        var role_id = document.getElementById('role_id');
        if (role_id.value <= 2) {
            adminVar.style.display = "block";
        } else {
            customerVar.style.display = "block";
        }

        function showVar() {
            adminVar.style.display = "none";
            customerVar.style.display = "none";
            if (role_id.value <= 2) {
                adminVar.style.display = "block";
            } else {
                customerVar.style.display = "block"
            }
        }
    </script>
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
