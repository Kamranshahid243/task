<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\CategoryDeleted;
use App\Notifications\Database\Admin\CategoryUpdated;
use App\Notifications\Database\Admin\NewCategoryAdded;

class SubcategoryController extends Controller
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
        return view('admin.subcategories.list', [
            'title'     => 'Admin | Subcategories Management',
            'page'      => 'subcategory-list',
            'child'     => '',
            'subcategories' => Subcategory::all(),
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
            'category_id' => 'required|integer'
        ]);

        $category = Category::find( request()->category_id );

        if( !$category ){
            return response()->json([
                'status' => 'error',
                'message' => 'Category does not exist!'
            ], 500);
        }

        if( !request()->has('attachments-0') ){
            return response()->json([
                'status' => 'error',
                'message' => 'Thumbnail is required!'
            ], 500);
        }

        $subcategory = new Subcategory;

        if (request()->has('attachments-0')) {
            $uploaded = handleImageUpload(request()->file('attachments-0'), 'images/categories', 200, 200);

            $subcategory->thumbnail = $uploaded['url'];
        }

        $subcategory->name         = request()->name;
        $subcategory->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $subcategory->description  = request()->description;
        $subcategory->is_paused    = (request()->status == "1") ? false : true;
        $subcategory->created_by   = auth()->user()->id;
        $subcategory->category_id  = request()->category_id;

        if( $subcategory->save() ){


            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new NewCategoryAdded(  $subcategory, auth()->user(), 'self-notify', 'subcategory' ));
            Notification::send( $superadmins, new NewCategoryAdded(  $subcategory, auth()->user(), 'all-notify', 'subcategory' ));

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
        $subcategory = Subcategory::find( $id );

        if( !$subcategory ){
            abort('404');
        }

        return view('admin.subcategories.edit', [
            'title'     => 'Admin | Categories Management',
            'page'      => 'category-list',
            'child'     => '',
            'subcategories' => Subcategory::all(),
            'found'     => $subcategory,
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
            'category_id' => 'required'
        ]);



        $category = Category::find( request()->category_id );

        if( !$category ){
            return response()->json([
                'status' => 'error',
                'message' => 'Category does not exist!'
            ], 500);
        }


        $subcategory = Subcategory::find( $id );

        if( !$subcategory ){
            return response()->json([
                'status' => 'error',
                'message' => 'Subcategory does not exist!'
            ], 500);
        }

        if (request()->has('attachments-0')) {
            $uploaded = handleImageUpload(request()->file('attachments-0'), 'images/categories', 200, 200);

            $thumb = $subcategory->thumbnail ? str_replace('public/', 'storage/', $subcategory->thumbnail) : null;

            if( $thumb ) {
                Storage::delete( $thumb );
            }

            $subcategory->thumbnail = $uploaded['url'];
        }

        $subcategory->name         = request()->name;
        $subcategory->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $subcategory->description  = request()->description;
        $subcategory->is_paused    = (request()->status == "1") ? false : true;
        $subcategory->category_id  = request()->category_id;


        if( $subcategory->save() ){


            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new CategoryUpdated(  $subcategory, auth()->user(), 'self-notify', 'subcategory' ));
            Notification::send( $superadmins, new CategoryUpdated(  $subcategory, auth()->user(), 'all-notify', 'subcategory' ));

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
        $subcategory = Subcategory::find( $id );

        $thumb = $subcategory->thumbnail ? str_replace('public/', 'storage/', $subcategory->thumbnail) : null;
        if( $subcategory->delete() ){



            if( $thumb ) {
                Storage::delete( $thumb );
            }

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new CategoryDeleted(  $subcategory, auth()->user(), 'self-notify', 'subcategory' ));
            Notification::send( $superadmins, new CategoryDeleted(  $subcategory, auth()->user(), 'all-notify', 'subcategory' ));

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
