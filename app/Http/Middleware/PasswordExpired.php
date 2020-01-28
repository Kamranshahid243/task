<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = $request->user();
        
        $guard = ( $user->role->nickname == 'admin' OR $user->role->nickname == 'superadmin') ? 'admin' : 'admin';

        if( $user->is_login_password_expiry_on ){
            if( $user->time_unit == 'seconds' ){
                if( \Carbon\Carbon::now()->diffInSeconds( $user->time_to_expire, false ) < 0 ){
                    Auth::guard( $guard )->logout();
                    return redirect('/admin');
                }
            }
            else if( $user->time_unit == 'minutes' ){
                if( \Carbon\Carbon::now()->diffInMinutes( $user->time_to_expire, false ) < 0 ){
                    Auth::guard( $guard )->logout();
                    return redirect('/admin');
                }
            }
            else if( $user->time_unit == 'hours' ){
                if( \Carbon\Carbon::now()->diffInHours( $user->time_to_expire, false ) < 0 ){
                    Auth::guard( $guard )->logout();
                    return redirect('/admin');
                }
            }
            else if( $user->time_unit == 'days' ){
                if( \Carbon\Carbon::now()->diffInDays( $user->time_to_expire, false ) < 0 ){
                    Auth::guard( $guard )->logout();
                    return redirect('/admin');
                }
            }

        }

        return $next($request);
    }
}
