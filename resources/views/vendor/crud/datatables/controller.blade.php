<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
<?='<?php'?>

namespace App\Http\Controllers\{{ $gen->modelClassName() }};

use App\Models\{{ $gen->modelClassName() }};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataTables\Admin\{{ $gen->modelClassName() }}DataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Database\Admin\{{ $gen->modelClassName() }}Blocked;
use App\Notifications\Database\Admin\{{ $gen->modelClassName() }}Created;
use App\Notifications\Database\Admin\{{ $gen->modelClassName() }}Deleted;
use App\Notifications\Database\Admin\{{ $gen->modelClassName() }}Unblocked;
use App\Notifications\Database\Admin\{{ $gen->modelClassName() }}DetailsUpdated;

class {{$gen->controllerClassName()}} extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index({{ $gen->modelClassName() }}DataTable $dataTable)
    {
        if(!empty(request('search')['value'])) {
            $model = {{ $gen->modelClassName() }}::select();
            return DataTables::eloquent($model)
<?php foreach ($fields as $field) { ?>
<?php if (!\Nvd\Crud\Db::isGuarded($field->name)) { ?>
<?php if (preg_match("/email/", $field->name)) { ?>
                ->addColumn('{{$field->name}}', function($query) {
                    return '<a href="mailto:'. $query->{{$field->name}} .'" class="text-black">'. $query->{{$field->name}} .'</a>';
                })
<?php } else { ?>
                ->addColumn('{{$field->name}}', function($query) {
                    if($query->{{$field->name}}) {
                        return $query->{{$field->name}};
                    }
                    return 'N/A';
                })
<?php } ?>
<?php } ?>
<?php } ?>
                ->addColumn('created_at', function($model) {
                    if($model->created_at) {
                        return $model->created_at->toFormattedDateString();
                    }
                    return 'N/A';

                })
                ->addColumn('updated_at', function($model) {
                    return $model->updated_at->toFormattedDateString();
                })
                ->addColumn('action', function($query) {
                    $links  = '<a href="'. url('/admin/{{ $gen->route() }}/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/{{ $gen->route() }}/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['{{ join("', '", collect($fields)->pluck('name')->all()) }}'])
                    ->smart(true)
                    ->toJson();
        } else if( empty( request('search')['value']) AND request('order')[0]['column'] >= 0 AND !empty( request('order')[0]['dir']) ){
            $model = {{ $gen->modelClassName() }}::select();
            return DataTables::eloquent($model)
                ->order(function ($query) {
                    $columns = ['{{ join("', '", collect($fields)->pluck('name')->all()) }}'];
                    $column = $columns[ request('order')[0]['column'] ];
                    $order  = request('order')[0]['dir'];
                    $query->orderBy($column, $order);
                })
<?php foreach ($fields as $field) { ?>
<?php if (!\Nvd\Crud\Db::isGuarded($field->name)) { ?>
<?php if (preg_match("/email/", $field->name)) { ?>
                ->addColumn('{{$field->name}}', function($query) {
                    return '<a href="mailto:'. $query->{{$field->name}} .'" class="text-black">'. $query->{{$field->name}} .'</a>';
                })
<?php } else { ?>
                ->addColumn('{{$field->name}}', function($query) {
                    if($query->{{$field->name}}) {
                        return $query->{{$field->name}};
                    }
                    return 'N/A';
                })
<?php } ?>
<?php } ?>
<?php } ?>
                ->addColumn('created_at', function($model) {
                    if($model->created_at) {
                        return $model->created_at->toFormattedDateString();
                    }
                    return 'N/A';

                })
                ->addColumn('updated_at', function($model) {
                    return $model->updated_at->toFormattedDateString();
                })
                ->addColumn('action', function($query) {
                    $links  = '<a href="'. url('/admin/{{ $gen->route() }}/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/{{ $gen->route() }}/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/{{ $gen->route() }}/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['{{ join("', '", collect($fields)->pluck('name')->all()) }}'])
                ->toJson();
        }

        return $dataTable->render('admin.list', [
            'title' => 'Admin | {{ $gen->titlePlural() }} Management',
            'page' => 'admin-list',
            'child' => '',
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function create()
    {
        return view('admin.create', [
            'title' => 'Admin | Create {{ $gen->titleSingular() }}',
            'page' => 'admin-list',
            'bodyClass' => $this->bodyClass
        ]);
    }

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

        $admin = new {{ $gen->modelClassName() }};

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
        } else {
            $admin->id = getCustomerID();
        }

        $admin->email               = $request->email;
        $admin->mobile              = $request->mobile;
        $admin->avatar              = $request->gender_id == '1' ? '/assets/images/avatars/male.png' : '/assets/images/avatars/female.png';

        if ($request->has('password') and $request->password) {
            $admin->password = bcrypt( $request->password );
        }

        if($admin->save()){
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = {{ $gen->modelClassName() }}::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new {{ $gen->modelClassName() }}Created( $admin, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new {{ $gen->modelClassName() }}Created( $admin, auth()->user(), 'all-notify' ));

            return response()->json( ['status' => 'success', 'message' => 'Account created successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to create account!'], 500);
    }

    public function show($id)
    {
        $admin = {{ $gen->modelClassName() }}::withTrashed()->where( 'id', $id )->first();

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

    public function edit($id)
    {
        $admin = {{ $gen->modelClassName() }}::find( $id );
        if(!{{ $gen->modelClassName() }}::find($id)){
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

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required',
            'gender_id'  => 'required',
            'role_id'    => 'required',
        ]);

        $admin = {{ $gen->modelClassName() }}::find( $id );

        if( !$admin ){
            return response()->json( ['status' => 'error', 'message' => 'Account does not exist!'], 500);
        }

        $admins = {{ $gen->modelClassName() }}::where( 'email', $request->email )->where('id', '!=', $id)->get();

        if( $admins AND $admins->count() ){
            return response()->json( ['status' => 'error', 'message' => 'The email has already been taken!'], 422);
        }

        $admin = {{ $gen->modelClassName() }}::find( $id );

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

        if( $request->has('password') and $request->password){
            $admin->password = bcrypt( $request->password );
        }

        if( $admin->save() ){

            $role = Role::where('nickname', 'superadmin')->first();
            $superadmins = {{ $gen->modelClassName() }}::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send(Auth::user(), new {{ $gen->modelClassName() }}DetailsUpdated( $admin, auth()->user(), 'self-notify'));
            Notification::send($superadmins, new {{ $gen->modelClassName() }}DetailsUpdated( $admin, auth()->user(), 'all-notify'));

            return response()->json(['status' => 'success', 'message' => 'Account updated successfully!', 'refresh' => true], 200);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to update account!'], 500);
    }

    public function unblock($id){
        $admin = {{ $gen->modelClassName() }}::find($id);
        if( $admin ){
            $admin->is_blocked = 0;
            if( $admin->save() ){
                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = {{ $gen->modelClassName() }}::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new {{ $gen->modelClassName() }}Unblocked( $admin, auth()->user(), 'self-notify' ));
                Notification::send( $superadmins, new {{ $gen->modelClassName() }}Unblocked( $admin, auth()->user(), 'all-notify' ));

                return response()->json( ['status' => 'success', 'message' => 'Account unblocked successfully!', 'refresh' => true], 200);
            }
        }
        return response()->json( ['status' => 'error', 'message' => 'Failed to unblock account!'], 500);
    }

    public function block($id){
        $admin = {{ $gen->modelClassName() }}::find($id);
        if( $admin ){
            $admin->is_blocked = 1;
            if( $admin->save() ){
                $role = Role::where( 'nickname', 'superadmin' )->first();
                $superadmins = {{ $gen->modelClassName() }}::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

                Notification::send( Auth::user(), new {{ $gen->modelClassName() }}Blocked( $admin, auth()->user(), 'self-notify' ));
                Notification::send( $superadmins, new {{ $gen->modelClassName() }}Blocked( $admin, auth()->user(), 'all-notify' ));

                return response()->json( ['status' => 'success', 'message' => 'Account blocked successfully!', 'refresh' => true], 200);
            }
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to block the account!'], 500);
    }


    public function destroy($id)
    {
        $user = {{ $gen->modelClassName() }}::find( $id );
        if(!$user){
            return response()->json( ['status' => 'error', 'message' => 'Account does not exist!'], 500);
        }

        $admin = $user;
        if( $user->delete() ){
            $role = Role::where( 'nickname', 'superadmin' )->first();
            $superadmins = {{ $gen->modelClassName() }}::where('role_id', $role->id)->where('id', '!=', auth()->user()->id)->get();

            Notification::send( Auth::user(), new {{ $gen->modelClassName() }}Deleted( $admin, auth()->user(), 'self-notify' ));
            Notification::send( $superadmins, new {{ $gen->modelClassName() }}Deleted( $admin, auth()->user(), 'all-notify' ));

            return response()->json( ['status' => 'success', 'message' => 'Account deleted successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to delete account!'], 500);
    }

}
