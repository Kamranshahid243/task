<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\State;
use App\Models\Country;
use App\Models\StatePricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\PricingDeleted;
use App\Notifications\Database\Admin\PricingUpdated;
use App\Notifications\Database\Admin\NewPricingAdded;

class StatePricingController extends Controller
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
        return view('admin.pricings.states.list', [
            'title'     => 'Admin | States Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'state', 
            'countries' => DB::table('auc_countries')->get(),
            'states'    => '',
            'pricings'  => StatePricing::all(), 
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
            'price_per_day' => 'required|integer',
            'states' => 'required|array',
            'country_id' => 'required',
        ]);


        $country = Country::find( request()->country_id );

        if( !$country ){
            return response()->json([
                'status' => 'error',
                'message' => 'Country does not exist.',
            ], 422);
        }

        $totalSaved = 0;

        $done = [];

        foreach( request()->states as $c){

            $state = State::find( $c );

            if( $state ){

                $found = StatePricing::where('name', $state->name)->get();

                if( !$found->count() ){
                    $saved = StatePricing::firstOrCreate([
                        
                        'nickname'      => str_replace(' ','-',strtolower($state->name)),
                        'name'          => $state->name,
                        'country_id'    => $country->id,
                        'price'         => request()->price_per_day,
                        'created_by'    => auth()->user()->id,
                    ]);

                 
                    if( $saved ){

                        $done[] = $saved;

                        $totalSaved++;
                    }
                }
            }
        }

      

        if( $totalSaved ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new NewPricingAdded( 'state', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewPricingAdded( 'state', $done, auth()->user(), 'all-notify' ));

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

        $editablePricing = StatePricing::find( $id );

        if( !$editablePricing ){
            abort('404');
        }

        $states = State::where('country_id', $editablePricing->country_id)->get();

        return view('admin.pricings.states.edit', [
            'title'     => 'Admin | States Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'state', 
            'countries' => DB::table('auc_countries')->get(),
            'pricings'  => StatePricing::all(), 
            'editablePricing' => $editablePricing,
            'states'    => $states,
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
            'price_per_day' => 'required|integer',
            'state_id' => 'required',
            'country_id' => 'required',
        ]);

        $totalSaved = 0;
        $done = [];

        $country = Country::find( request()->country_id );

        if( !$country ){
            return response()->json([
                'status' => 'error',
                'message' => 'Country does not exist.',
            ], 422);
        }   

        $pricing = StatePricing::find( $id );
          
        if( !$pricing ){
            return response()->json([
                'status' => 'error',
                'message' => 'State pricing does not exist.'
            ], 422);
        }

        $found = State::find( request()->state_id );

        if( $found AND $found->name != $pricing->name ){
           
            $f = StatePricing::where( 'name', $found->name )->first();

            if( $f AND $f->id != $pricing->id ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Same state with a price already exists.'
                ], 422);
            } 
        }

        $done = [];
        $pricing->country_id = $country->id;
        $pricing->nickname   = str_replace(' ','-',strtolower($found->name));
        $pricing->name       = $found->name;
        $pricing->price      = request()->price_per_day;
      
       
        if( $pricing->save() ){

            $done[] = $pricing;

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingUpdated( 'state', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingUpdated( 'state', $done, auth()->user(), 'all-notify' ));

            return response()->json([
                'status' => 'success',
                'message' => 'Action was successful',
                'refresh' => true,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Records already exist'
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
        $done = [];
        $done[] = $price = StatePricing::find( $id );
        if( $price->delete() ){
            
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingDeleted( 'state', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingDeleted( 'state', $done, auth()->user(), 'all-notify' ));

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
