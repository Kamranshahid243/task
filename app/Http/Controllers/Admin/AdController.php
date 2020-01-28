<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function store(Request $request)
    {
        $ad=new Ad();
        $ad->title=$request->title;
        $ad->admin_id=1;
        $ad->points=$request->points;
        if($ad->save()){
            return "saved";
        }
        return abort(404,'not saved');

    }

    public function load(Request $request)
    {
        if($request->wantsJson()){
            return Ad::findRequested();
        }
        return view('admin.ad.index');
    }

    public function update(Request $request)
    {
    }
}
