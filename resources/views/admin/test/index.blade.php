<?php
//public function show($id)
//{
//    $article = Article::find($id);
//    $object  = HouseObject::find( request('objectId'));
//
//    if( !$article AND request()->ajax() ){
//        return response()->json([
//            'status' => 'error',
//            'message' => 'Sorry! the selected article does not exist!',
//        ], 422);
//    }
//    else if( !$object AND request()->ajax() ){
//        return response()->json([
//            'status' => 'error',
//            'message' => 'Sorry! the object does not exist!',
//        ], 422);
//    }
//    else if( $article AND request()->ajax() ){
//
//
//        $content = $article->content;
//
//        $content = str_replace( '&nbsp;', '', $content );
//        $content = str_replace( '{OBJECT_NAME}', ( isset( $object->title ) ? $object->title : '' ), $content );
//        $content = str_replace( '{STREET}', ( isset( $object->street ) ? $object->street : '' ), $content );
//        $content = str_replace( '{STREET_ADDITION}', ( isset( $object->streetAddition) ? $object->streetAddition: '' ), $content );
//        $content = str_replace( '{ZIP}', ( isset( $object->zip ) ? $object->zip : '' ), $content );
//        $content = str_replace( '{CITY}', ( isset( $object->city ) ? $object->city : '' ), $content );
//        $content = str_replace( '{BASE_RENT}', ( isset( $object->baseRent ) ? $object->baseRent : '' ), $content );
//        $content = str_replace( '{LIVING_SPACE}', ( isset( $object->livingSpace ) ? $object->livingSpace : '' ), $content );
//        $content = str_replace( '{NUMBER_ROOMS}', ( isset( $object->numberRooms ) ? $object->numberRooms : '' ), $content );
//
//
//        // return getArticleParts( $content );
//
//
//
//        return response()->json([
//            'status' => 'success',
//            'article' => getArticleParts( $content ),
//        ], 200);
//    }
//    else if( !$article  ){
//        return redirect('/articles/others')->with('status', '<div class="alert alert-danger">The article you trying to view does not exist.</div>');
//    }
//
//
//
//    $data = [
//        'title' => 'Read Article',
//        'page' => 'articles',
//        'child' => 'view-all-mine',
//        'article' => $article
//    ];
//
//    return view('articles.view-my', $data );
//}
?>
@extends('layouts.master')

<?php
$title=  '';
$page=  '';
$child=  '';
$bodyClass='skin-blue ';
?>

@section('style-sheets')
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/skins/_all-skins.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/select2/dist/css/select2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="summernote-bs4.css" rel="stylesheet">
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1126px;"  ng-controller="TestController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1></h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-header">
                            Create
                        </div>
                            <div class="container mt-5 mb-5">
                                <div id="summernote">dsfds</div>
                            </div>
                        <div class="box-body box-profile">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Template Type</label>
                                    <select class="form-control" ng-model="type">
                                        <option ng-repeat="type in templateTypes" value="@{{type}}">@{{type}}</option>
                                    </select>
                                </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Template</label>
                                <textarea type="text" ng-model="body" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Role</label>
                                    <select class="form-control" ng-model="role_id">
                                        <option ng-repeat="role in roles" value="@{{role.id}}">@{{role.name}}</option>
                                    </select>
                                </div>
                            <div class="btn-group"  role="group" aria-label="Basic example">
                                <button type="button" ng-click="insert(var)" ng-repeat="var in getVariables()" class="btn btn-info">@{{ var }}</button>
                            </div>
                            <br><br>
                                <button class="btn btn-primary" ng-click="saveTemplate()" ng-disabled="!body && !role_id">Save</button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <script src="summernote-bs4.js"></script>
    <script>
        $('#summernote').summernote();
    </script>
@endsection
@include('admin.test.test-ng-app')
