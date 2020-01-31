<?php

namespace App\DataTables\Admin;

use App\Models\Admin;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlockedUsersDataTable extends DataTable
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
            ->addColumn('first_name', function( $query ){
                $dom  = '<h2 class="table-avatar clearfix">';
                $dom .= '<a href="'.url('/admin/blocked-users/'.$query->id).'" class="avatar pull-left"><img alt="" class="thumb-round-34x34" src="'.asset( $query->avatar ).'"></a>';
                $dom .= '<a href="'.url('/admin/blocked-users/'.$query->id).'" class="pull-left">'.$query->first_name.' '.$query->last_name.'</a><br><span>'.$query->role->name.'</span>';
                $dom .= '</h2>';

                return $dom;
            })

            ->addColumn('email', function( $query ){
                return '<a href="mailto:'. $query->email .'" class="text-black">'. $query->email .'</a>';
            })
            ->addColumn('mobile', function( $query ){
                if( $query->mobile ){
                    return $query->mobile;
                }
                return 'N/A';

            })
            ->addColumn('role_id', function( $query ){
                return $query->role->name;
            })

            ->addColumn('created_by', function( $query ){

                if( $query->created_by ){
                    return $query->creator->first_name.' '.$query->creator->last_name;
                }
                return 'N/A';

            })
            ->addColumn('created_at', function( $query ){
                if( $query->created_at ){
                    return $query->created_at->toFormattedDateString();
                }
                return 'N/A';

            })
            ->rawColumns(['id','first_name',  'email', 'mobile', 'role_id', 'created_at']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Admin\AdminDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Admin $model)
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
            ->addColumn([ 'data' => 'first_name',  'title' => 'Full Name' ])
            ->addColumn([ 'data' => 'email','title' => 'Email Address' ])
            ->addColumn([ 'data' => 'mobile','title' => 'Mobile Number' ])
            ->addColumn([ 'data' => 'role_id',  'title' => 'Role' ])
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
