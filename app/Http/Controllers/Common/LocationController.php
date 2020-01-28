<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function getStates( $id ){

        $states = DB::table('auc_states')->select(['id', 'name'])->where('country_id', $id)->get();

        return response()->json(['states' => $states ]);


    }
    public function getCities( $id ){
        $cities = DB::table('auc_cities')->select(['id', 'name'])->where('state_id', $id)->get();

        return response()->json(['cities' => $cities ]);
    }
}
