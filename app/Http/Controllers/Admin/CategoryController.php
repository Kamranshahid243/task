<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\CategoryDeleted;
use App\Notifications\Database\Admin\CategoryUpdated;
use App\Notifications\Database\Admin\NewCategoryAdded;

class CategoryController extends Controller
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
        return view('admin.categories.list', [
            'title'     => 'Admin | Categories Management', 
            'page'      => 'category-list', 
            'child'     => '', 
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

        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|boolean',
            
        ]);

       
        if( !request()->has('attachments-0') ){
            return response()->json([
                'status' => 'error',
                'message' => 'Thumbnail is required!'
            ], 500);
        }

        $category = new Category;

        if (request()->has('attachments-0')) {
            $uploaded = handleImageUpload(request()->file('attachments-0'), 'images/categories', 200, 200);

            $category->thumbnail = $uploaded['url'];
        }

        $category->name         = request()->name;
        $category->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $category->description  = request()->description;
        $category->is_paused    = (request()->status == "1") ? false : true;
        $category->created_by   = auth()->user()->id;

        if( $category->save() ){
            

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new NewCategoryAdded(  $category, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewCategoryAdded(  $category, auth()->user(), 'all-notify' )); 

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
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
        $category = Category::find( $id );

        if( !$category ){
            abort('404');
        }

        return view('admin.categories.edit', [
            'title'     => 'Admin | Categories Management', 
            'page'      => 'category-list', 
            'child'     => '',
            'found'     => $category,  
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

        request()->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|boolean',
            
        ]);


       
        $category = Category::find( $id );

        if( !$category ){
            return response()->json([
                'status' => 'error',
                'message' => 'Category does not exist!'
            ], 500);
        }

        if (request()->has('attachments-0')) {
            $uploaded = handleImageUpload(request()->file('attachments-0'), 'images/categories', 200, 200);

            $thumb = $category->thumbnail ? str_replace('public/', 'storage/', $category->thumbnail) : null;

            if( $thumb ) {
                Storage::delete( $thumb );
            }

            $category->thumbnail = $uploaded['url'];
        }

        $category->name         = request()->name;
        $category->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $category->description  = request()->description;
        $category->is_paused    = (request()->status == "1") ? false : true;

        
        if( $category->save() ){
            

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new CategoryUpdated(  $category, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new CategoryUpdated(  $category, auth()->user(), 'all-notify' )); 

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
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
        $category = Category::find( $id );

        $thumb = $category->thumbnail ? str_replace('public/', 'storage/', $category->thumbnail) : null;
        if( $category->delete() ){
            
            

            if( $thumb ) {
                Storage::delete( $thumb );
            }

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new CategoryDeleted(  $category, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new CategoryDeleted(  $category, auth()->user(), 'all-notify' )); 

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful!',
                'refresh' => true,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Action was failed in error!',
        ], 500);
    }

  
}
