<?php

namespace App\DataTables\Admin;

use App\Models\Admin;
use App\Models\EmailTemplate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdsDataTable extends DataTable
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
        ->rawColumns(['id','title', 'description', 'customer_id','category_id','sub_category_id','is_paused','created_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
//     * @param \App\Admin\AdminDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AdsDataTable $model)
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
            ->addColumn([ 'data' => 'title',  'title' => 'Title' ])
            ->addColumn([ 'data' => 'category_id',  'title' => 'Category' ])
            ->addColumn([ 'data' => 'sub_category_id',  'title' => 'Sub Category' ])
            ->addColumn([ 'data' => 'description','title' => 'Description' ])
            ->addColumn([ 'data' => 'customer_id',  'title' => 'Created_by' ])
            ->addColumn([ 'data' => 'is_paused',  'title' => 'Status' ])
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