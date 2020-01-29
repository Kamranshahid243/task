<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
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


        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit <?= $gen->titleSingular() ?> Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-verticle form" method="post" action="{{ url('/admin/<?= $gen->route() ?>/'.$<?= $gen->modelVariableName() ?>->id) }}">
                @csrf
                @method('PUT')
                <div class="box-body">
                   <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <?php foreach ($fields as $field) { ?>
                                    <?php
                                    $defaultAttrs = 'class="form-control" value="{{$'. $gen->modelVariableName() .'->'. $field->name .' }}"';
                                    $placeholder = 'placeholder="' . ucwords(str_replace("_", " ", $field->name)) . '"';
                                    ?>
                                    <?php if (!\Nvd\Crud\Db::isGuarded($field->name)) { ?>
                                        <label><?= ucwords(str_replace("_", " ", $field->name)) ?><?php if ($field->required) { ?>
                                                <span class="text-red">*</span><?php } ?></label>

                                        <?php if ($field->type == 'enum') { ?>
                                            <select class="form-control" name="<?= $field->name ?>">
                                                <?php foreach ($field->enumValues as $enumValue) {
                                                    echo '<option value="' . $enumValue . '">' . $enumValue . '</option>';
                                                } ?>
                                            </select>
                                        <?php } elseif ($field->type == 'text') { ?>
                                            <textarea <?= $defaultAttrs ?> <?= $placeholder ?>></textarea>
                                        <?php } elseif (preg_match("/date|dob/", $field->name)) { ?>
                                            <input <?= $defaultAttrs ?> <?= $placeholder ?> type="date"/>
                                        <?php } else { ?>
                                            <input <?= $defaultAttrs ?> <?= $placeholder ?>/>
                                        <?php } ?>

                                    <?php } ?>
                                <?php } ?>
                            </div>
                       </div>
                   </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-primary pull-right form-btn">Save Changes</button>
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
