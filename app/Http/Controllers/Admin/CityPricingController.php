<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Role;
use App\Models\Admin;
use App\Models\State;
use App\Models\Country;
use App\Models\CityPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\PricingDeleted;
use App\Notifications\Database\Admin\PricingUpdated;
use App\Notifications\Database\Admin\NewPricingAdded;

class CityPricingController extends Controller
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
        return view('admin.pricings.cities.list', [
            'title'     => 'Admin | Cities Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'city', 
            'countries' => DB::table('auc_countries')->get(),
            'states'    => '',
            'pricings'  => CityPricing::all(), 
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
            'cities' => 'required|array',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer'
        ]);


        $country = Country::find( request()->country_id );

        if( !$country ){
            return response()->json([
                'status' => 'error',
                'message' => 'Country does not exist.',
            ], 422);
        }

        $state = State::find( request()->state_id );

        if( !$state ){
            return response()->json([
                'status' => 'error',
                'message' => 'State does not exist.',
            ], 422);
        }

        $totalSaved = 0;

        $done = [];

        foreach( request()->cities as $c){

            $city = City::find( $c );

            if( $city ){

                $found = CityPricing::where('name', $city->name)->get();

                if( !$found->count() ){
                    $saved = CityPricing::firstOrCreate([
                        
                        'nickname'      => str_replace(' ','-',strtolower($city->name)),
                        'name'          => $city->name,
                        'country_id'    => $country->id,
                        'state_id'      => $state->id,
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

            Notification::send( Auth::user(), new NewPricingAdded( 'city', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewPricingAdded( 'city', $done, auth()->user(), 'all-notify' ));

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

        $editablePricing = CityPricing::find( $id );

        if( !$editablePricing ){
            abort('404');
        }

        $states = State::where('country_id', $editablePricing->country_id)->get();
        $cities = City::where('state_id', $editablePricing->state_id)->get();

        return view('admin.pricings.cities.edit', [
            'title'     => 'Admin | Cities Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'state', 
            'countries' => DB::table('auc_countries')->get(),
            'pricings'  => CityPricing::all(), 
            'editablePricing' => $editablePricing,
            'states'    => $states,
            'cities'    => $cities, 
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
            'city_id' => 'required',
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
        
        $state = State::find( request()->state_id );

        if( !$state ){
            return response()->json([
                'status' => 'error',
                'message' => 'State does not exist.',
            ], 422);
        } 

        $pricing = CityPricing::find( $id );
          
        if( !$pricing ){
            return response()->json([
                'status' => 'error',
                'message' => 'State pricing does not exist.'
            ], 422);
        }

        $found = City::find( request()->city_id );

        if( $found AND $found->name != $pricing->name ){
           
            $f = CityPricing::where( 'name', $found->name )->first();

            if( $f AND $f->id != $pricing->id ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Same state with a price already exists.'
                ], 422);
            } 
        }

        $done = [];
        $pricing->country_id = $country->id;
        $pricing->state_id   = $state->id;
        $pricing->nickname   = str_replace(' ','-',strtolower($found->name));
        $pricing->name       = $found->name;
        $pricing->price      = request()->price_per_day;
      
       
        if( $pricing->save() ){

            $done[] = $pricing;

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingUpdated( 'city', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingUpdated( 'city', $done, auth()->user(), 'all-notify' ));

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
        $done[] = $price = CityPricing::find( $id );
        if( $price->delete() ){
            
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingDeleted( 'city', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingDeleted( 'city', $done, auth()->user(), 'all-notify' ));

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
