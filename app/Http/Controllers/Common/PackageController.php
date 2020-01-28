<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function __construct(){
        $this->middleware('auth:seller');
    }

    public function index(){

        return view('seller.package.index', [
            'title'             => SELLER_BUY_PACKAGE_PAGE, 
            'page'              => 'properties', 
            'child'             => '', 
            'packages'          => Package::where('is_visible', 1)->get(),    
            'bodyClass'         => $this->bodyClass
        ]);
    }
}
