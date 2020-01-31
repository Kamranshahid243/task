<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\RegistrationFieldSetting;
use App\Models\Role;
use App\Notifications\Database\Admin\RegistrationSettingsUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class RegistrationFieldSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(AdsDataTable $dataTable)
    {


        return view('admin.settings.registration_settings.index', [
            'title' => 'Admin | Registration Field Settings',
            'page' => 'settings',
            'child' => 'field-settings',
            'data' => RegistrationFieldSetting::with('creator')->get(),
            'bodyClass' => $this->bodyClass
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $rec = RegistrationFieldSetting::find($id);
        $bool = !$rec->is_disabled;
        if ($rec->update(['is_disabled' => $bool,'created_by'=>Auth::user()->id])) {
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();
            Notification::send( Auth::user(), new RegistrationSettingsUpdated(  $rec, auth()->user(), 'self-notify', "Registration Settings" ));
            Notification::send( $superadmins, new RegistrationSettingsUpdated
            (  $rec, auth()->user(), 'all-notify', "Registration Settings" ));
            return response()->json(['status' => 'success', 'message' => 'Settings updated!', 'refresh' => true,'data'=>RegistrationFieldSetting::with(['creator'])->get()], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to update settings!'], 500);
    }

}
