<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Category;
use App\Models\SubcategoryMetadata;
use App\Notifications\Database\Admin\SubCategoryMetaDataDeleted;
use App\Notifications\Database\Admin\SubCategoryMetaDataUpdate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\SubCategoryMetaDataSaved;

class SubcategoryMetadataController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subcategory_metadata.list', [
            'title'     => 'Admin | Subcategories Metadata Management',
            'page'      => 'subcategory-metadata-list',
            'child'     => '',
            'subcategories' => Subcategory::all(),
            'subcategories_metadata' => SubcategoryMetadata::all(),
            'categories'  => Category::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = Category::find( $request->category_id );
        if( !$category ){
            return response()->json( ['status' => 'error', 'message' => 'Record Not found!', 'refresh' => true], 200);
        }

        $subcategory = Subcategory::find( $request->sub_category_id );
        if(!$subcategory ){
            return response()->json([
                'status' => 'error',
                'message' => 'Subcategory does not exist!'
            ], 500);
        }
        $request->validate([
            'key'=>'required'
        ]);
        $subcategoryMeta = new SubcategoryMetadata();
        $subcategoryMeta->category_id = $request->category_id;
        $subcategoryMeta->sub_category_id =$request->sub_category_id;
        $subcategoryMeta->key = $request->key;
        $subcategoryMeta->created_by = Auth::user()->id;
        if( $subcategoryMeta->save() ){
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new SubCategoryMetaDataSaved(  $subcategoryMeta, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new SubCategoryMetaDataSaved(  $subcategoryMeta, auth()->user(), 'all-notify' ));
            return response()->json( ['status' => 'success', 'message' => 'Record saved successfully!', 'refresh' => true], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'One or more records already exist'
        ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategoryMetaRec = SubcategoryMetadata::find( $id );

        if( !$subcategoryMetaRec ){
            abort('404');
        }

        return view('admin.subcategory_metadata.edit', [
            'title'     => 'Admin | Categories Management',
            'page'      => 'subcategory-metadata-list',
            'child'     => '',
            'subcategories' => Subcategory::all(),
            'found'     => $subcategoryMetaRec,
            'subcategories_metadata' => SubcategoryMetadata::all(),
            'categories'  => Category::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find( request()->category_id );
        if( !$category ){
            return response()->json([
                'status' => 'error',
                'message' => 'Category does not exist!'
            ], 500);
        }
        $subcategory = Subcategory::find( $request->sub_category_id );
        if( !$subcategory ){
            return response()->json([
                'status' => 'error',
                'message' => 'Subcategory does not exist!'
            ], 500);
        }
        $sCMetaData=SubcategoryMetadata::find($id);
        if(!$sCMetaData){
            return response()->json([
                'status' => 'error',
                'message' => 'Subcategory Meta does not exist!'
            ], 500);
        }
        if($sCMetaData) {
            $sCMetaData->sub_category_id = request()->sub_category_id;
            $sCMetaData->category_id = $request->category_id;
            $sCMetaData->key = request()->key;
            $sCMetaData->created_by = Auth::user()->id;
        }
        if( $sCMetaData->save() ){
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new SubCategoryMetaDataUpdate(  $sCMetaData, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new SubCategoryMetaDataUpdate(  $sCMetaData, auth()->user(), 'all-notify' ));
            return response()->json( ['status' => 'success', 'message' => 'Record saved successfully!', 'refresh' => true], 200);
            return response()->json( ['status' => 'success', 'message' => 'Action was successful', 'refresh' => true], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'One or more records already exist'
        ], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategoryMetaDlt = SubcategoryMetadata::find($id);
        if(!$subcategoryMetaDlt){
            return response()->json( ['status' => 'error', 'message' => 'Record does not exist!'], 500);
        }
            if ($subcategoryMetaDlt->delete()){
                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new SubCategoryMetaDataDeleted(  $subcategoryMetaDlt, auth()->user(), 'self-notify' ));
                Notification::send( $superadmins, new SubCategoryMetaDataDeleted(  $subcategoryMetaDlt, auth()->user(), 'all-notify' ));
                return response()->json( ['status' => 'success', 'message' => 'Record deleted successfully!', 'refresh' => true], 200);
            }
        return response()->json( ['status' => 'error', 'message' => 'Failed to delete Record!'], 500);
    }
}
