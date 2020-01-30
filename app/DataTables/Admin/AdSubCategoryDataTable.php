<?php

namespace App\DataTables\Admin;

use App\Models\AdCategory;
use App\Models\Admin;
use App\Models\AdSubCategory;
use App\Models\EmailTemplate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdSubCategoryDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables( $query )
            ->addColumn('id', function( $query ){

                return $query->id;

            })
            ->addColumn('category_id', function( $query ){
                if( $query->category_id ){
                    return $query->category_id;
                }
                return 'N/A';

            })->addColumn('nickname', function( $query ){
                if( $query->nickname ){
                    return $query->nickname;
                }
                return 'N/A';

            })
            ->addColumn('name', function( $query ){
                return $query->name;
            })

            ->addColumn('thumbnail', function( $query ){
                if($query->thumbnail){
                    $dom  = '<h2 class="table-avatar clearfix">';
                    $dom .= '<a href="'.url('/admin/ad-sub-categories/'.$query->id).'" class="avatar pull-left"><img alt="" class="thumb-round-34x34" src="'.asset( $query->avatar ).'"></a>';
                    $dom .= '<a href="'.url('/admin/ad-sub-categories/'.$query->id).'" class="pull-left">'.$query->name;
                    $dom .= '</h2>';
                    return $dom;
                }
                return 'N/A';

            })
            ->addColumn('title', function( $query ){
                if( $query->title ){
                    return $query->title;
                }
                return 'N/A';

            })->addColumn('description', function( $query ){
                if( $query->description ){
                    return $query->description;
                }
                return 'N/A';

            })->addColumn('created_by', function( $query ){
                if( $query->created_by ){
                    return $query->created_by->createdBy->name;
                }
                return 'N/A';

            })->addColumn('is_paused', function( $query ){
                if( $query->is_paused ){
                    return $query->is_paused;
                }
                return 'N/A';

            })
            ->addColumn('action', function( $query ){
                $links  = '<a href="'. url('/admin/ad-sub-categories/'.$query->id) .'" data-toggle="tooltip" data-placement="top" title="View" data-action="view" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-eye"></i></a>';
                $links .= ' <a href="'. url('/admin/ad-sub-categories/'.$query->id.'/edit') .'" data-toggle="tooltip" data-placement="top" title="Edit" data-action="edit" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-edit"></i></a>';
                $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ad-sub-categories/'.$query->id.'" data-toggle="tooltip" data-placement="top" title="Delete" data-action="delete" class="custom-table-btn btn btn-xs btn-default" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';
                if( $query->is_blocked ){
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ad-sub-categories/'.$query->id.'/unblock" data-toggle="tooltip" data-placement="top" title="Unblock" data-action="unblock" class="custom-table-btn btn btn-xs btn-default" data-original-title="Unblock"><i class="fa fa-check"></i></a>';
                }
                else{
                    $links .= ' <a href="#" data-id="'.$query->id.'" data-url="/admin/ad-sub-categories/'.$query->id.'/block" data-toggle="tooltip" data-placement="top" title="Block" data-action="block" class="custom-table-btn btn btn-xs btn-default" data-original-title="Block"><i class="fa fa-ban"></i></a>';
                }

                return $links;
            })
            ->rawColumns(['id','category_id', 'nickname',  'name', 'thumbnail', 'title', 'description', 'created_by', 'is_paused']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AdSubCategory $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()

            ->addColumn([ 'data' => 'id', 'title' => 'ID' ])
            ->addColumn([ 'data' => 'category_id', 'title' => 'Category' ])
            ->addColumn([ 'data' => 'name',  'title' => 'Name' ])
            ->addColumn([ 'data' => 'nickname',  'title' => 'Nick Name' ])
            ->addColumn([ 'data' => 'thumbnail','title' => 'Thumbnail' ])
            ->addColumn([ 'data' => 'title','title' => 'Title' ])
            ->addColumn([ 'data' => 'created_by',  'title' => 'Created By' ])
            ->addColumn([ 'data' => 'created_at',  'title' => 'Created At' ])
            ->minifiedAjax()
            ->addAction(['width' => '140px'])
            ->parameters();
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin\Admin_' . date('YmdHis');
    }
}
