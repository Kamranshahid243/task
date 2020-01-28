<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Notifications\Email\Admin\OTPEmailNotification;
use App\Notifications\Email\Admin\LoginApprovalCodeEmailNotification;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashoard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

        /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.admin.login', ['title'=>'Admin | Login', 'bodyClass' => 'login-body']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        // if ($this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);

        //     return $this->sendLockoutResponse($request);
        // }
   

       $request->session()->forget('login_notification_message');
        
        $user = Admin::where('email', $request->email)->first();

        if( $user->role->nickname != 'admin' AND  $user->role->nickname != 'superadmin'){
            return response()->json([
                'status' => 'error',
                'message' => 'Account does not exist!'
            ], 401);
        }
        else{

            if( $user->is_login_approval_code_on ){

                if( $request->has('login_approval_code') ){
                    if( !Hash::check( $request->login_approval_code, $user->login_approval_code) ){
                        $code = Str::random(10);
                        $user->login_approval_code = bcrypt( $code );
                        $user->save();
                        
                        session(['login_notification_message' => 'We emailed you a new login approval code.', 'code_sent' => true ]);
                        

                        Notification::send( $user, new LoginApprovalCodeEmailNotification( $code ));
                        
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Incorrect login approval code!'
                        ], 422);
                    }
                    else{


                        if ($this->attemptLogin($request)) {
                            $request->session()->forget('login_approval_code_error');
                           
                            $user->login_approval_code = null;
                            $user->save();

                            $request->session()->regenerate();
                            //$this->clearLoginAttempts($request);
            
                            return response()->json([
                                'status'  => 'success',
                                'message' => 'Redirecting...!',
                                'refresh'  => true,
                            ], 200);
                        }
                    }
                }
                else{
                    $code = Str::random(10);
                    $user->login_approval_code = bcrypt( $code );
                    $user->save();

                    session(['login_notification_message' => 'We emailed you a new login approval code.', 'code_sent' => true ]);

                    Notification::send( $user, new LoginApprovalCodeEmailNotification( $code ));

                    return response()->json([
                        'status' => 'success',
                        'message' => 'We have emailed you a login approval code.',
                        'refresh' => true,
                    ]);
                }


            }
            else if( $user->is_login_otp_on ){
    
                if( !session('otp_sent') ){
                    $password = Str::random(10);
                    $user->password = bcrypt( $password );
                    $user->save();

                    session(['login_notification_message' => 'We emailed you OTP (one time password).', 'otp_sent' => true ]);
                        

                    Notification::send( $user, new OTPEmailNotification( $password ));

                    return response()->json([
                        'status' => 'info',
                        'message' => 'We emailed you an OTP (One Time Password)!',
                        'refresh' => true,
                    ], 200);
                }
                else{

                    if( session('otp_sent') AND $this->attemptLogin($request)){
                        $request->session()->forget('login_notification_message');
                        $request->session()->forget('otp_sent');
                        
                        $request->session()->regenerate();
                        //$this->clearLoginAttempts($request);
        
                        return response()->json([
                            'status'  => 'success',
                            'message' => 'Redirecting...!',
                            'refresh'  => true,
                        ], 200);
                    }

                    $password = Str::random(10);
                    $user->password = bcrypt( $password );
                    $user->save();

                    session(['login_notification_message' => 'We emailed you OTP (one time password).', 'otp_sent' => true ]);
                        

                    Notification::send( $user, new OTPEmailNotification( $password ));

                    return response()->json([
                        'status' => 'info',
                        'message' => 'We emailed you an OTP (One Time Password)!',
                        'refresh' => true,
                    ], 200);

                }
            }
            else{
                if ($this->attemptLogin($request)) {

                    $request->session()->forget('login_notification_message');
                    $request->session()->forget('code_sent');
                    
                    $request->session()->regenerate();
                    //$this->clearLoginAttempts($request);
    
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'Redirecting...!',
                        'refresh'  => true,
                    ], 200);
                }
            }

         

        }
    

        return response()->json([
            'status' => 'error',
            'message' => 'Incorrect email or password!'
        ], 401);

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return response()->json([
            'status'  => 'success',
            'message' => 'Authenticated Redirecting...',
            'action'  => 'refresh'
        ], 200);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
