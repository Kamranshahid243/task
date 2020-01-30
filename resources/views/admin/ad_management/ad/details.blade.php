@extends('layouts.master')
<?php
$title=  '';
$page=  '';
$child=  '';
$bodyClass='skin-blue ';
?>@section('title', $title)

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
                    <h3 class="box-title">Ad Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-verticle form" method="post" action="{{ url('/admin/ads') }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Your Ad<span class="text-red">*</span></label>
                                            <select name="ad_id" id="" class="form-control">
                                                @if($ads->count())
                                                    @foreach($ads as $ad)
                                                        <option value="{{$ad->id}}">{{$ad->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sub Category<span class="text-red">*</span></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title<span class="text-red">*</span></label>
                                            <input type="text" class="form-control" name="title" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Play/Pause<span class="text-red">*</span></label>
                                            <select class="form-control" id="is_paused" name="is_paused">
                                                <option value="0">Play</option>
                                                <option value="1">Paused</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label><br>
                                            <textarea name="description" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">

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
