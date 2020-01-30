<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdminDataTable;
use App\DataTables\Admin\AdsDataTable;
use App\DataTables\Admin\EmailTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Ads;
use App\Models\Category;
use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\Gender;
use App\Models\Role;
use App\Models\Subcategory;
use App\Models\SubcategoryMetadata;
use App\Notifications\Database\Admin\UserDeleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class AdsController extends Controller
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
        if (!empty(request('search')['value'])) {


            $model = Ads::select();

            return DataTables::eloquent($model)
                ->addColumn('id', function ($user) {
                    return $user->id;
                })
                ->addColumn('title', function( $query ){
                    if( $query->title ){
                        return $query->title;
                    }
                    return 'N/A';

                })
                ->addColumn('description', function( $query ){
                    return $query->description;
                })->addColumn('customer_id', function( $query ){
                    return $query->description;
                })->addColumn('category_id', function( $query ){
                    return $query->category_id;
                })->addColumn('sub_category_id', function( $query ){
                    return $query->sub_category_id;
                })->addColumn('is_paused', function( $query ){
                    return $query->is_paused;
                })
                ->addColumn('created_at', function( $query ){
                    if( $query->created_at ){
                        return $query->created_at->toFormattedDateString();
                    }
                    return 'N/A';

                })
                ->addColumn('action', function( $query ){
                    $links  = '<a href="'. url('/admin/ads/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/ads/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['action'])
                ->smart(true)
                ->toJson();
        } else if (empty(request('search')['value']) AND request('order')[0]['column'] >= 0 AND !empty(request('order')[0]['dir'])) {

            $model = Ads::select();

            return DataTables::eloquent($model)
                ->order(function ($query) {

                    $columns = [
                        'id','title', 'description', 'customer_id','category_id','sub_category_id','is_paused','created_at',
                    ];

                    $column = $columns[request('order')[0]['column']];
                    $order = request('order')[0]['dir'];

                    $query->orderBy($column, $order);

                })
                ->addColumn('title', function( $query ){
                    if( $query->title ){
                        return $query->title;
                    }
                    return 'N/A';

                })
                ->addColumn('description', function( $query ){
                    return $query->description;
                })->addColumn('customer_id', function( $query ){
                    return $query->description;
                })->addColumn('category_id', function( $query ){
                    return $query->category_id;
                })->addColumn('sub_category_id', function( $query ){
                    return $query->sub_category_id;
                })->addColumn('is_paused', function( $query ){
                    return $query->is_paused;
                })
                ->addColumn('created_at', function( $query ){
                    if( $query->created_at ){
                        return $query->created_at->toFormattedDateString();
                    }
                    return 'N/A';

                })
                ->addColumn('action', function( $query ){
                    $links  = '<a href="'. url('/admin/ads/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                    $links .= ' <a href="'. url('/admin/ads/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if( $query->is_blocked ){
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    }
                    else{
                        $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ads/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['action'])
                ->smart(true)
                ->toJson();

        }

        return $dataTable->render('admin.ad_management.ad.list', [
            'title' => 'Admin | Ads Management',
            'page' => 'ads-list',
            'child' => '',
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function edit($id)
    {
        $admin=new Admin();
        $adminVar=$admin->getTableColumns('admins');
        $adminVar=['first_name','last_name','email','avatar','mobile','time_unit'];
        foreach ($adminVar as $key=>$column){
            $adminVar[$key]="{".$column."} ";
        }

        $customer = new Customer();
        $customerVar=$customer->getTableColumns('customers');
        $customerVar=['first_name','last_name','email','avatar','mobile','time_unit'];
        foreach ($customerVar as $key=>$column){
            $customerVar[$key]="{".$column."} ";
        }

        $template = EmailTemplate::find($id);

        if (!$template) {
            abort('404');
        }

        return view('admin.email_template.edit', [
            'title' => 'Admin | User Template',
            'page' => 'Update Template',
            'child' => '',
            'data' => $template,
            'adminVar' => $adminVar,
            'customerVar' => $customerVar,
            'roles' => Role::all(),
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
        return view('admin.ad_management.ad.create', [
            'title' => 'Admin | Create Ad',
            'page' => 'create-ad',
            'child' => '',
            'categories' => Category::all(),
            'subCategories' => Subcategory::all(),
            'bodyClass' => $this->bodyClass
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ads = new Ads();
        if(!$request->title){
            return response()->json(['status' => 'error', 'message' => 'Title Required'], 200);
        }
        $ads->title = $request->title;
        $ads->description = $request->description;
        $ads->category_id = $request->category_id;
        $ads->sub_category_id = $request->sub_category_id;
        $ads->is_paused = $request->is_paused;
        $ads->customer_id=Auth::user()->id;
        if ($ads->save())
            return response()->json(['status' => 'success', 'message' => 'Ad created successfully!', 'refresh'=>true], 200);
        return response()->json(['status' => 'error', 'message' => 'Failed to create Ad!'], 500);

    }

    public function adMetadataForm()
    {
        $ads=Ads::orderBy('customer_id', 'desc')->where('customer_id',Auth::user()->id)->take(5)->get();;
        return view('admin.ad_management.ad.details',[
            'ads' => $ads,
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

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
    public function update(Request $request, $id)
    {
        $template = EmailTemplate::find($id);
        if ($template) {
            $template->body = $request->body;
            $template->role_id = $request->role_id;
            $template->save();
               return response()->json(['status' => 'success', 'message' => 'Template updated successfully!','refresh'=>true], 200);

        }
        return response()->json(['status' => 'error', 'message' => 'Error while updating template'], 200);
        return response()->json(['status' => 'error', 'message' => 'Error while updating template'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emailTemplate = EmailTemplate::find( $id );
        if( !$emailTemplate ){
            return response()->json( ['status' => 'error', 'message' => 'Template does not exist!'], 500);
        }
        if( $emailTemplate->delete() ){
            return response()->json( ['status' => 'success', 'message' => 'Template deleted successfully!', 'refresh' => true], 200);
        }

        return response()->json( ['status' => 'error', 'message' => 'Failed to delete template!'], 500);
    }
}
