<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\PasswordReset;

class PasswordController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function showPasswordResetForm(){
        return view('admin.password-reset', [
            'title' => 'Admin | Password Reset', 
            'page' => 'profile', 
            'child' => 'profile_reset_password', 
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function passwordUpdate( Request $request ){
        $user = Auth::user();

        if( empty($request->cpassword) OR empty($request->npassword) OR empty($request->cnpassword) ){
            return response()->json( ['status' => 'error', 'message' => 'All password fields are mandatory!'] , 422);
        }    
        else if( strlen($request->cpassword) < 6 OR strlen($request->npassword) < 6 OR strlen($request->cnpassword) < 6){
            return response()->json( ['status' => 'error', 'message' => 'Password must be at least 6 characters!'] , 422);
        }
        else if( $request->npassword != $request->cnpassword ){
            return response()->json( ['status' => 'error', 'message' => 'Mismatch new and confirm new passwords!'] , 422);
        }
        else if( !Hash::check( $request->cpassword, $user->password) ){
            return response()->json( ['status' => 'error', 'message' => 'Incorrect current password!'] , 422);
        }

        $user->password = Hash::make( $request->npassword );

        if( $user->save() ){

            Notification::send( Auth::user(), new PasswordReset());

            return response()->json( ['status' => 'success', 'message' => 'Password reset successfully!', 'refresh'=>true] , 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to reset password!'] , 422);
    }
}
