<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    public function index(){
        return view('admin.dashboard', ['title' => 'Admin | Dashboard', 'page' => 'dashboard', 'child' =>'', 'bodyClass' => $this->bodyClass]);
    }
    public function routes(){

        return response()->json([
            'status' => 'success',
            'user'   => Auth::user(),
            'routes' => Auth::user()->urls 
        ]);

    }
}
