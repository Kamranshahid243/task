<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Dashboard\Admin\OTPStatusChanged;
use App\Notifications\Database\Admin\PasswordExpiryStatusChanged;
use App\Notifications\Database\Admin\LoginApprovalCodeStatusChanged;

class SecurityController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function showSecurityForms(){
        return view('admin.security', [
            'title' => 'Admin | Security Settings', 
            'page' => 'security', 
            'child' => '', 
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function loginApprovalCode( $status = null ){
        
        if( $status ){
            
            $user = Auth::user();
            $message = '';

            if( $status == 'enable' ){
                $user->is_login_approval_code_on = true;
                $message = 'Login approval code enabled successfully!';
            }
            else{
                $user->is_login_approval_code_on = false;
                $message = 'Login approval code disabled successfully!';
            }
            $user->is_login_otp_on = false;
            $user->is_login_password_expiry_on = false;
            $user->time_unit_id = null;

            if( $user->save() ){

                Notification::send( Auth::user(), new LoginApprovalCodeStatusChanged( $status ));

                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'refresh' => true,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Error occured while enabling login approval code.',
        ], 500);
    }

    public function otp( $status = null ){
        
        if( $status ){
            
            $user = Auth::user();
            $message = '';

            if( $status == 'enable' ){
                $user->is_login_otp_on = true;
                $user->opassword = $user->password;
                $message = 'OTP enabled successfully!';
            }
            else{
                $user->is_login_otp_on = false;
                $user->password = $user->opassword;
                $message = 'OTP disabled successfully!';
            }
            $user->is_login_approval_code_on = false;
            $user->is_login_password_expiry_on = false;
            $user->time_unit_id = null;

            if( $user->save() ){

                Notification::send( Auth::user(), new OTPStatusChanged( $status ));

                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'refresh' => true,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Error occured while enabling login approval code.',
        ], 500);
    }

    public function passwordExpiry( $status = null ){
        
        if( $status ){

            if( $status != 'enable' AND $status != 'disable'){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized action.',
                ], 422);   
            }
            
            $user = Auth::user();
            $message = '';

            if( $status == 'enable' ){

                if( request()->time_unit != 'seconds' AND 
                    request()->time_unit != 'minutes' AND 
                    request()->time_unit != 'hours' AND 
                    request()->time_unit != 'days'){

                    return response()->json([
                        'status' => 'error',
                        'message' => 'Please select a valid time unit.',
                    ], 422);    
                }
                else if( request()->has('duration') AND request()->duration < 1 ){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'The duration should be a positive number.',
                    ], 422);   
                }
                else if( request()->has('duration') AND request()->duration < 1 ){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'The duration should be a positive number.',
                    ], 422);   
                }


                $user->is_login_password_expiry_on = true;
                $user->time_unit = request()->time_unit;
                $message = 'Password expiry enabled successfully!';
                

                if( request()->time_unit == 'seconds' ){
                    $user->time_to_expire = \Carbon\Carbon::now()->addSeconds( request()->duration );
                }
                else if( request()->time_unit == 'minutes' ){
                    $user->time_to_expire = \Carbon\Carbon::now()->addMinutes( request()->duration );
                }
                else if( request()->time_unit == 'hours' ){
                    $user->time_to_expire = \Carbon\Carbon::now()->addHours( request()->duration );
                }
                else if( request()->time_unit == 'days' ){
                    $user->time_to_expire = \Carbon\Carbon::now()->addDays( request()->duration );
                }
            }
            else{
                $user->is_login_password_expiry_on = false;
                $user->time_unit = null;
                $user->time_to_expire = null;
                $message = 'Password expiry disabled successfully!';
            }
            $user->is_login_otp_on = false;
            $user->is_login_approval_code_on = false;
            
            $user->time_unit_id = null;

            if( $user->save() ){

                Notification::send( Auth::user(), new PasswordExpiryStatusChanged( $status ));

                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'refresh' => true,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Error occured while enabling login approval code.',
        ], 500);

    }
}
