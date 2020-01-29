<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdminDataTable;
use App\DataTables\Admin\EmailTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\EmailTemplate;
use App\Models\Gender;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(EmailTemplateDataTable $dataTable )
    {
        if( !empty( request('search')['value']) ) {


            $model = EmailTemplate::select();

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
                        return $user->created_at->toFormattedDateString();
                    }
                    return 'N/A';

                })

                ->addColumn('updated_at', function( $user ){
                    return $user->updated_at->toFormattedDateString();
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
                ->rawColumns(['first_name', 'action'])
                ->smart(true)
                ->toJson();
        }
        else if( empty( request('search')['value']) AND request('order')[0]['column'] >= 0 AND !empty( request('order')[0]['dir']) ){

            $model = EmailTemplate::select();

            return DataTables::eloquent($model)
                ->order(function ($query) {

                    $columns = [
                        'id',
                        'body',
                        'role_id',
                        'created_at',
                        'updated_at'
                    ];

                    $column = $columns[ request('order')[0]['column'] ];
                    $order  = request('order')[0]['dir'];

                    $query->orderBy( $column, $order);

                })

                ->addColumn('role_id', function( $user ){
                    return $user->role->name;
                })
                ->addColumn('created_at', function( $user ){
                    return $user->created_at;
                })

                ->addColumn('updated_at', function( $user ){
                    return $user->updated_at->toFormattedDateString();
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
                ->rawColumns(['first_name', 'action'])
                ->toJson();

        }

        return $dataTable->render('admin.email_template.list', [
            'title' => 'Admin | Email Templates',
            'page' => 'email-list',
            'child' => '',
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
        return view('admin.email_template.create', [
            'title' => 'Admin | Create Email',
            'page' => 'email-list',
            'child' => '',
            'countries' => DB::table('auc_countries')->get(),
            'roles' => Role::all(),
            'genders' => Gender::all(),
            'bodyClass' => $this->bodyClass
        ]);    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
