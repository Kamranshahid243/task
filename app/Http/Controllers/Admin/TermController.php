<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Term;

use App\Notifications\Database\Admin\TermsUpdated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class TermController extends Controller
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

    public function index()
    {
        $term = Term::find(1);

        return view('admin.terms.index', [
            'title' => 'Admin | Terms and Policy',
             'term'=>$term->terms_and_conditions,
             'policy'=>$term->privacy_policy,
            'page' => 'email-list',
            'child' => '',
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function store(Request $request)
    {

            $data=[];

            $terms = Term::first();
            $actionType = '';

            if( !$terms ){
                $terms = new Term;
            }

            if( $request->has('terms_conditions') ){
                $terms->terms_and_conditions = $request->terms_and_conditions;
                $actionType = 'terms';
            }
            if( $request->has('privacy_policy') ){
                $terms->privacy_policy = $request->privacy_policy;
                $actionType = 'policy';
            }

            if( $terms->save() ){
                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new TermsUpdated(  $terms, auth()->user(), 'self-notify', $actionType ));
                Notification::send( $superadmins, new TermsUpdated(  $terms, auth()->user(), 'all-notify', $actionType ));
                return response()->json( [
                        'status' => 'success',
                        'refresh' => true,
                        'message' => 'Terms updated Successfully!'], 200);
            }

        return response()->json( ['status' => 'error', 'message' => 'Something went wronge!'], 200);
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

}
