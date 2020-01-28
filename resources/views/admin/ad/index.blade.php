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
@section('head-scripts')

@endsection
@section('style-sheets')
    <link rel="stylesheet" href="{{ asset('/assets/dist/css/skins/_all-skins.min.css') }}">

@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1126px;" ng-controller="MainController">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">

                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-header">
                            Create Ad
                        </div>
                        <div class="box-body box-profile">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" ng-model="title" class="form-control" id="title">
                            </div>
                            <div class="form-group">
                                <label for="points">Points</label>
                                <input type="number" class="form-control" ng-model="points" id="points">
                            </div>
                            <br><br>
                            <button class="btn btn-primary" ng-click="save()" ng-disabled="!title && !points">Save</button>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
            </div>
            @include('admin.ad.show')

        </section>
        <!-- /.content -->
    </div>
    @include('admin.ad.ad-ng-app')
@endsection

