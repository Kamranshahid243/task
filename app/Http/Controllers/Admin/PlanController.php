<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\PlanDeleted;
use App\Notifications\Database\Admin\PlanUpdated;
use App\Notifications\Database\Admin\NewPlanAdded;

class PlanController extends Controller
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
        return view('admin.plans.list', [
            'title'     => 'Admin | Plans Management', 
            'page'      => 'plans-list', 
            'child'     => '', 
            'plans'  => Plan::all(), 
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
            'price' => 'required|numeric'
        ]);

       


        $plan = new Plan;

        $plan->name         = request()->name;
        $plan->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $plan->description  = request()->description;
        $plan->price        = request()->price;
        $plan->is_paused    = (request()->status == "1") ? false : true;
        $plan->created_by   = auth()->user()->id;

        if( $plan->save() ){
            

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new NewPlanAdded(  $plan, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewPlanAdded(  $plan, auth()->user(), 'all-notify' )); 

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
        $plan = Plan::find( $id );

        if( !$plan ){
            abort('404');
        }

        return view('admin.plans.edit', [
            'title'     => 'Admin | Plans Management', 
            'page'      => 'Plan-list', 
            'child'     => '',
            'found'     => $plan,  
            'plans'  => Plan::all(), 
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
            'price'  => 'required|numeric'
            
        ]);


       
        $plan = Plan::find( $id );

        if( !$plan ){
            return response()->json([
                'status' => 'error',
                'message' => 'Plan does not exist!'
            ], 500);
        }

      
        $plan->name         = request()->name;
        $plan->nickname     = str_replace(' ','-', strtolower( request()->name ));
        $plan->description  = request()->description;
        $plan->price        = request()->price;
        $plan->is_paused    = (request()->status == "1") ? false : true;

        
        if( $plan->save() ){
            

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PlanUpdated(  $plan, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PlanUpdated(  $plan, auth()->user(), 'all-notify' )); 

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
        $plan = Plan::find( $id );

      
        if( $plan->delete() ){
            
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PlanDeleted(  $plan, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PlanDeleted(  $plan, auth()->user(), 'all-notify' )); 

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
