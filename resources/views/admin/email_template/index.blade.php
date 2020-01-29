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
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1126px;">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
{{--    @include('admin.email_template.test-ng-app')--}}
@endsection

