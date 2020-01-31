<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\BlockedCustomersDataTable;
use App\DataTables\Admin\BlockedUsersDataTable;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Admin;
use App\Models\Gender;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataTables\Admin\AdminDataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\UserBlocked;
use App\Notifications\Database\Admin\UserCreated;
use App\Notifications\Database\Admin\UserDeleted;
use App\Notifications\Database\Admin\UserUnblocked;
use App\Notifications\Database\Admin\UserDetailsUpdated;

class BlockedCustomersController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( BlockedCustomersDataTable $dataTable )
    {
        if( !empty( request('search')['value']) ) {


            $model = Customer::where('is_blocked','=',1);

            return DataTables::eloquent($model)
                ->addColumn('role_id', function( $user ){
                    return $user->role->name;
                })
                ->addColumn('first_name', function( $query ){
                    $dom  = '<h2 class="table-avatar clearfix">';
                    $dom .= '<a href="'.url('/admin/users/management/'.$query->id).'" class="avatar pull-left"><img alt="" class="thumb-round-34x34" src="'.asset( $query->avatar ).'"></a>';
                    $dom .= '<a href="'.url('/admin/users/management/'.$query->id).'" class="pull-left">'.$query->first_name.' '.$query->last_name.'</a><br><span>'.$query->role->name.'</span>';
                    $dom .= '</h2>';

                    return $dom;
                })
                ->addColumn('mobile', function( $user ){
                    if( $user->mobile ){
                        return $user->mobile;
                    }
                    return 'N/A';

                })
                ->addColumn('created_at', function( $user ){
                    if( $user->created_at ){
                        return $user->created_at;
                    }
                    return 'N/A';

                })

                ->addColumn('updated_at', function( $user ){
                    return $user->updated_at;
                })
                ->addColumn('action', function( $query ){
                    $links  = '<a href="'. url('/admin/users/management/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/users/management/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['action','first_name'])
                ->smart(true)
                ->toJson();
        }
        else if( empty( request('search')['value']) AND request('order')[0]['column'] >= 0 AND !empty( request('order')[0]['dir']) ){

            $model = Customer::where('is_blocked','=',1);

            return DataTables::eloquent($model)
                ->order(function ($query) {

                    $columns = [
                        'id',
                        'first_name',
                        'mobile',
                        'email',
                        'role_id',
                        'created_at'
                    ];

                    $column = $columns[ request('order')[0]['column'] ];
                    $order  = request('order')[0]['dir'];

                    $query->orderBy( $column, $order);

                })

                ->addColumn('role_id', function( $user ){
                    return $user->role->name;
                })
                ->addColumn('first_name', function( $query ){
                    $dom  = '<h2 class="table-avatar clearfix">';
                    $dom .= '<a href="'.url('/admin/users/management/'.$query->id).'" class="avatar pull-left"><img alt="" class="thumb-round-34x34" src="'.asset( $query->avatar ).'"></a>';
                    $dom .= '<a href="'.url('/admin/users/management/'.$query->id).'" class="pull-left">'.$query->first_name.' '.$query->last_name.'</a><br><span>'.$query->role->name.'</span>';
                    $dom .= '</h2>';

                    return $dom;
                })
                ->addColumn('mobile', function( $user ){
                    if( $user->mobile ){
                        return $user->mobile;
                    }
                    return 'N/A';

                })
                ->addColumn('created_at', function( $user ){
                    if( $user->created_at ){
                        return $user->created_at;
                    }
                    return 'N/A';

                })

                ->addColumn('updated_at', function( $user ){
                    return $user->updated_at;
                })
                ->addColumn('action', function( $query ){
                    $links  = '<a href="'. url('/admin/users/management/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/users/management/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/users/management/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['first_name','action'])
                ->toJson();

        }

        return $dataTable->render('admin.reports.blocked-customer-list', [
            'title' => 'Admin | Blocked Customers Report',
            'page' => 'reports',
            'child' => 'blocked-customers-list',
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create', [
            'title' => 'Admin | Blocked Customers List',
            'page' => 'reports',
            'child' => 'blocked-customers-list',
            'countries' => DB::table('auc_countries')->get(),
            'roles' => Role::all(),
            'genders' => Gender::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|unique:admins',
            'password'   => 'required',
            'gender_id'  => 'required',
            'role_id'    => 'required',
        ]);

        $admin = new Admin;

        foreach($request->all() as $i=>$d){

            if( $i != 'id' AND $i != '_method' AND $i != '_token' ){

                if( $i != 'email' AND $i != 'password'){
                    $admin->{$i} = $d;
                }
            }
        }

        $role = Role::find( request()->role_id);
        if( $role AND ( $role->nickname == 'admin' AND $role->nickname == 'superadmin' ) ){
            $admin->id = getAdminID();
        }
        else{
            $admin->id = getCustomerID();
        }

        $admin->email               = $request->email;
        $admin->mobile              = $request->mobile;
        $admin->avatar              = $request->gender_id == '1' ? '/assets/images/avatars/male.png' : '/assets/images/avatars/female.png';

        if( $request->has('password') and $request->password ){
            $admin->password = bcrypt( $request->password );
        }

        if( $admin->save() ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new UserCreated( $admin, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new UserCreated( $admin, auth()->user(), 'all-notify' ));

            return response()->json( ['status' => 'success', 'message' => 'Account created successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to create account!'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::withTrashed()->where( 'id', $id )->first();


        if( !$admin ){
            abort('404');
        }

        return view('admin.show', [
            'title' => 'Admin | User Details',
            'page' => 'admin-list',
            'child' => '',
            'countries' => DB::table('auc_countries')->get(),
            'admin' => $admin,
            'roles' => Role::all(),
            'genders' => Gender::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $admin = Admin::find( $id );

        if( !Admin::find( $id ) ){
            abort('404');
        }

        return view('admin.edit', [
            'title' => 'Admin | User Edit',
            'page' => 'list-admins',
            'child' => '',
            'countries' => DB::table('auc_countries')->get(),
            'admin' => $admin,
            'roles' => Role::all(),
            'genders' => Gender::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'gender_id'  => 'required',
            'role_id'    => 'required',
        ]);

        $admin = Admin::find( $id );

        if( !$admin ){

            return response()->json( ['status' => 'error', 'message' => 'Account does not exist!'], 500);
        }

        $admins = Admin::where( 'email', $request->email )->where('id', '!=', $id)->get();


        if( $admins AND $admins->count() ){
            return response()->json( ['status' => 'error', 'message' => 'The email has already been taken!'], 422);
        }


        $admin = Admin::find( $id );

        foreach($request->all() as $i=>$d){

            if( $i != 'id' AND $i != '_method' AND $i != '_token' ){

                if( $i != 'email' AND $i != 'password'){
                    $admin->{$i} = $d;
                }
            }
        }

        $admin->email               = $request->email;
        $admin->mobile              = $request->mobile;
        $admin->avatar              = $request->gender_id == '1' ? '/assets/images/avatars/male.png' : '/assets/images/avatars/female.png';

        if( $request->has('password') and $request->password ){
            $admin->password = bcrypt( $request->password );
        }

        if( $admin->save() ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new UserDetailsUpdated( $admin, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new UserDetailsUpdated( $admin, auth()->user(), 'all-notify' ));

            return response()->json( ['status' => 'success', 'message' => 'Account updated successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to update account!'], 500);
    }

    public function unblock($id){
        $admin = Admin::find($id);
        if( $admin ){
            $admin->is_blocked = 0;
            if( $admin->save() ){

                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new UserUnblocked( $admin, auth()->user(), 'self-notify' ));
                Notification::send( $superadmins, new UserUnblocked( $admin, auth()->user(), 'all-notify' ));

                return response()->json( ['status' => 'success', 'message' => 'Account unblocked successfully!', 'refresh' => true], 200);
            }
        }
        return response()->json( ['status' => 'error', 'message' => 'Failed to unblock account!'], 500);
    }

    public function block($id){
        $admin = Admin::find($id);
        if( $admin ){
            $admin->is_blocked = 1;
            if( $admin->save() ){

                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new UserBlocked( $admin, auth()->user(), 'self-notify' ));
                Notification::send( $superadmins, new UserBlocked( $admin, auth()->user(), 'all-notify' ));

                return response()->json( ['status' => 'success', 'message' => 'Account blocked successfully!', 'refresh' => true], 200);
            }
        }
        return response()->json( ['status' => 'error', 'message' => 'Failed to block the account!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Admin::find( $id );
        if( !$user ){
            return response()->json( ['status' => 'error', 'message' => 'Account does not exist!'], 500);
        }

        $admin = $user;

        if( $user->delete() ){

            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = Admin::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new UserDeleted( $admin, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new UserDeleted( $admin, auth()->user(), 'all-notify' ));

            return response()->json( ['status' => 'success', 'message' => 'Account deleted successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to delete account!'], 500);
    }
}
