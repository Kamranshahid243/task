<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\CountryPricing;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\PricingDeleted;
use App\Notifications\Database\Admin\PricingUpdated;
use App\Notifications\Database\Admin\NewPricingAdded;

class CountryPricingController extends Controller
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
        return view('admin.pricings.countries.list', [
            'title'     => 'Admin | Countries Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'country', 
            'countries' => DB::table('auc_countries')->get(),
            'pricings'  => CountryPricing::all(), 
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
            'countries' => 'required|array'
        ]);

        $totalSaved = 0;

        $done = [];

        foreach( request()->countries as $c){

            $country = Country::find( $c );

            if( $country ){

                $found = CountryPricing::where('name', $country->name)->get();

                if( !$found->count() ){
                    $saved = CountryPricing::firstOrCreate([
                        
                        'nickname'      => $country->sortname,
                        'name'          => $country->name,
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

            Notification::send( Auth::user(), new NewPricingAdded( 'country', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new NewPricingAdded( 'country', $done, auth()->user(), 'all-notify' ));

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

        $editablePricing = CountryPricing::find( $id );

        if( !$editablePricing ){
            abort('404');
        }

        return view('admin.pricings.countries.edit', [
            'title'     => 'Admin | Countries Pricings', 
            'page'      => 'pricing-list', 
            'child'     => 'country', 
            'countries' => DB::table('auc_countries')->get(),
            'pricings'  => CountryPricing::all(), 
            'editablePricing' => $editablePricing,
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
            'country_id' => 'required'
        ]);

        $totalSaved = 0;
        $done = [];


        $pricing = CountryPricing::find( $id );
          
        if( !$pricing ){
            return response()->json([
                'status' => 'error',
                'message' => 'Country pricing does not exist.'
            ], 422);
        }

        $found = Country::find( request()->country_id );

        if( $found AND $found->name != $pricing->name ){
           
            $f = CountryPricing::where( 'name', $found->name )->first();

            if( $f AND $f->id != $pricing->id ){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Same country with a price already exists.'
                ], 422);
            } 
        }

        $done = [];
    
        $pricing->nickname = $found->sortname;
        $pricing->name     = $found->name;
        $pricing->price    = request()->price_per_day;
      
       
        if( $pricing->save() ){

            $done[] = $pricing;

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingUpdated( 'country', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingUpdated( 'country', $done, auth()->user(), 'all-notify' ));

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
        $done[] = $price = CountryPricing::find( $id );
        if( $price->delete() ){
            
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new PricingDeleted( 'country', $done, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new PricingDeleted( 'country', $done, auth()->user(), 'all-notify' ));

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
