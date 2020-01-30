<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdCategoryDataTable;
use App\DataTables\Admin\AdSubCategoryDataTable;
use App\DataTables\Admin\EmailTemplateDataTable;
use App\Http\Controllers\Controller;
use App\Models\AdCategory;
use App\Models\Admin;
use App\Models\AdSubCategory;
use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class AdSubCategoryController extends Controller
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

    public function index(AdSubCategoryDataTable $dataTable)
    {
        if (!empty(request('search')['value'])) {

            $model = AdSubCategory::select();

            return DataTables::eloquent($model)
                ->addColumn('id', function ($user) {
                    return $user->id;
                })
                ->addColumn('thumbnail', function( $query ){
                    if($query->thumbnail){
                        $dom  = '<h2 class="table-avatar clearfix">';
                        $dom .= '<a href="'.url('/admin/ad-categories/'.$query->id).'" class="avatar pull-left"><img alt="" class="thumb-round-34x34" src="'.asset( $query->avatar ).'"></a>';
                        $dom .= '<a href="'.url('/admin/ad-categories/'.$query->id).'" class="pull-left">';
                        $dom .= '</h2>';
                        return $dom;
                    }
                    return 'N/A';

                })
                ->addColumn('category_id', function ($user) {
                    if ($user->category_id) {
                        return $user->category_id;
                    }
                    return 'N/A';

                })->addColumn('name', function ($user) {
                    if ($user->name) {
                        return $user->name;
                    }
                    return 'N/A';

                })

                ->addColumn('nickname', function ($user) {
                    if ($user->nickname) {
                        return $user->nickname;
                    }
                    return 'N/A';

                }) ->addColumn('title', function ($user) {
                    if ($user->title) {
                        return $user->title;
                    }
                    return 'N/A';

                })
                ->addColumn('description', function ($user) {
                    if ($user->nickname) {
                        return $user->nickname;
                    }
                    return 'N/A';

                })
                ->addColumn('created_by', function ($user) {
                    if ($user->created_by) {
                        return $user->created_by->creator->name;
                    }
                    return 'N/A';

                })->addColumn('created_at', function ($user) {
                    if ($user->created_at) {
                        return $user->created_at;
                    }
                    return 'N/A';

                })
                ->addColumn('action', function ($query) {
                    $links='';
                    $links .= ' <a href="' . url('/admin/ad-sub-categories' . $query->id . '/edit') . '" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-sub-categories/' . $query->id . '" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if ($query->is_blocked) {
                        $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-sub-categories' . $query->id . '/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    } else {
                        $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-sub-categories' . $query->id . '/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['action'])
                ->smart(true)
                ->toJson();
        } else if (empty(request('search')['value']) AND request('order')[0]['column'] >= 0 AND !empty(request('order')[0]['dir'])) {

            $model = AdSubCategory::select();

            return DataTables::eloquent($model)
                ->order(function ($query) {

                    $columns = [
                        'id',
                        'category_id',
                        'nickname',
                        'name',
                        'thumbnail',
                        'description',
                        'title',
                        'created_by',
                        'updated_at'
                    ];

                    $column = $columns[request('order')[0]['column']];
                    $order = request('order')[0]['dir'];

                    $query->orderBy($column, $order);

                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })
                ->addColumn('updated_at', function ($user) {
                    return $user->updated_at;
                })
                ->addColumn('action', function ($query) {
                    $links='';
                    $links .= ' <a href="' . url('/admin/ad-categories/' . $query->id . '/edit') . '" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                    $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-categories/' . $query->id . '" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                    if ($query->is_blocked) {
                        $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-categories' . $query->id . '/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                    } else {
                        $links .= ' <a href="#" data-id="' . $query->id . '" data-url="/admin/ad-categories/' . $query->id . '/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                    }

                    return $links;
                })
                ->rawColumns(['action'])
                ->toJson();

        }

        return $dataTable->render('admin.ad_management.ad_category.list', [
            'title' => 'Admin | Ad Category',
            'page' => 'ad-category-list',
            'child' => '',
            'bodyClass' => $this->bodyClass
        ]);
    }

    public function edit($id)
    {
        $editCat = AdCategory::find($id);

        if (!$editCat) {
            abort('404');
        }

        return view('admin.ad_management.ad_category.edit', [
            'title' => 'Admin | Update Ad Category Template',
            'page' => 'Update Ad Category Template',
            'child' => '',
            'data' => $editCat,
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
        return view('admin.ad_management.ad_category.create', [
            'title' => 'Admin | Create Ad Category',
            'page' => 'ad-category-list',
            'child' => '',
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
        $adCategory = new AdCategory();
        $adCategory->name = $request->name;
        $adCategory->nickname = $request->nickname;
        $adCategory->title = $request->title;
        $adCategory->description = $request->description;
        $adCategory->created_by = Auth::user()->id;

        if ($adCategory->save())
            return response()->json(['status' => 'success', 'message' => 'Category created successfully!'], 200);
        return response()->json(['status' => 'error', 'message' => 'Failed to create category!'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $updateCat = AdCategory::find($id);
        if ($updateCat) {
            $updateCat->name = $request->name;
            $updateCat->title = $request->title;
            $updateCat->nickname = $request->nickname;
            $updateCat->description = $request->description;
            $updateCat->save();
               return response()->json(['status' => 'success', 'message' => 'Ad Category updated successfully!','refresh'=>true], 200);

        }
        return response()->json(['status' => 'error', 'message' => 'Error while updating Ad Category'], 200);
        return response()->json(['status' => 'error', 'message' => 'Error while updating Ad Category'], 200);
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
