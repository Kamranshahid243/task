<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Gender;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\ProfileUpdated;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function test()
    {
        return view('admin.test.index');
    }
    public function ad()
    {
        return view('admin.ad.index');
    }

    public function index(){



        $genders = Gender::all();
        $countries = Country::all();
        return view('admin.profile', [
            'title' => 'Admin | Profile',
            'page' => 'profile',
            'child' => 'profile_update',
            'genders' => $genders ,
            'countries' => $countries,
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function update(Request $request){

        $this->validate($request, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'mobile'     => 'required',
            'gender_id'  => 'required',
            'country_id' => 'required',
            'state_id'   => 'required',
            'city_id'    => 'required'
        ]);

        $admins = Admin::where( 'email', $request->email )->get();

        if( count($admins) > 1 ){
            foreach( $admins as $admin ){
                if( $admin->id != Auth::user()->id AND $admin->email == $request->email ){
                    return response()->json( ['status' => 'error', 'message' => 'The email has already been taken!'], 422);
                }
            }
        }
        else if(count($admins) == 1){
            if( $admins[0]->id != Auth::user()->id AND $admins[0]->email == $request->email ){
                return response()->json( ['status' => 'error', 'message' => 'The email has already been taken!'], 422);
            }
        }

        $admin = Auth::user();

        foreach($request->all() as $i=>$d){

            if( $i != 'email' AND $i  AND $i != 'gender_'){
                $admin->{$i} = $d;
            }
        }

        $admin->email               = $request->email;
        $admin->mobile               = $request->mobile;


        if(Auth::user()->avatar == '/assets/images/male.png' OR Auth::user()->avatar == '/assets/images/female.png'){
            $admin->avatar  = $request->gender == 1 ? '/assets/images/male.png' : '/assets/images/female.png' ;
        }




        if( $admin->save() ){

            Notification::send( Auth::user(), new ProfileUpdated());

            return response()->json( ['status' => 'success', 'message' => 'Profile updated successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to update profile!'], 500);


    }
}
