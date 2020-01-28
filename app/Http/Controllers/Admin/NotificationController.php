<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){

        if( Auth::user()->unreadNotifications->count() ){
            foreach (Auth::user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
        }

      
        return view('admin.notifications.list', [
            'title' => 'Admin | Notifications', 
            'page' => '',
            'child' => '',
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function destroy( $id ){
       if( Notification::where('id', $id)->where('notifiable_id', Auth::user()->id)->first()->delete() ){
           return response()->json([
               'status' => 'success',
               'message' => 'Notification deleted successfully!',
           ], 200);
       }
       return response()->json([
            'status' => 'error',
            'message' => 'Error occured while deleting the notification!',
        ], 500);
    }
}
