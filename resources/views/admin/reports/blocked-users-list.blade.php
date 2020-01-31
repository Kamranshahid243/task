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
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Blocked Users</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-striped custom-table datatable auc-table-with-thumbs', 'width' => '100%', 'cellspacing' => '0'])  !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    </section>
    <!-- /.content -->
</div>


<!-- Modal -->
<!-- /.modal -->

<!-- Modal -->
<!-- /.modal -->

<!-- Modal -->
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

{!! $dataTable->scripts() !!}

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
@endsection
