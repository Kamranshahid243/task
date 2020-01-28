<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\FaqDeleted;
use App\Notifications\Database\Admin\FaqUpdated;
use App\Notifications\Database\Admin\NewFaqAdded;

class FaqController extends Controller
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
        return view('admin.faqs.list', [
            'title'     => 'Admin | FAQs Management', 
            'page'      => 'faqs-list', 
            'child'     => '', 
            'faqs'      =>  Faq::all(), 
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
        return view('admin.faqs.create', [
            'title'     => 'Admin | Create FAQs', 
            'page'      => 'faqs-list', 
            'child'     => '', 
            'bodyClass' => $this->bodyClass
        ]);
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
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faq = new Faq;
        $faq->question = request()->question;
        $faq->answer   = request()->answer;
        $faq->created_by = auth()->user()->id;
        
        if( $faq->save() ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new NewFaqAdded(  $faq, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewFaqAdded(  $faq, auth()->user(), 'all-notify' )); 

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create FAQ',
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
        $faq = Faq::find( $id );

        if( !$faq ){
            abort('404');
        }

        return view('admin.faqs.edit', [
            'title'     => 'Admin | FAQs Management', 
            'page'      => 'faqs-list', 
            'child'     => '', 
            'faq'      => $faq, 
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
            'question' => 'required',
            'answer' => 'required'
        ]);



        $faq = Faq::find( $id );
        
        if( !$faq ){
            return response()->json([
                'status' => 'error',
                'message' => 'This faq does not exist.',
            ], 422);
        }
        
        $faq->question = request()->question;
        $faq->answer   = request()->answer;

        
        if( $faq->save() ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new FaqUpdated(  $faq, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new FaqUpdated(  $faq, auth()->user(), 'all-notify' )); 

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create FAQ',
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
        $faq = Faq::find( $id );

        if( !$faq ){
            return response()->json([
                'status'  => 'error',
                'message' => 'This faq does not exist'
            ], 422);
        }

        if( $faq ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new FaqDeleted(  $faq, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new FaqDeleted(  $faq, auth()->user(), 'all-notify' )); 


            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create FAQ',
        ], 500);
    }
}
