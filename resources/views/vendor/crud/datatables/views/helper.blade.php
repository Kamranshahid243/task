<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
{{'<?'}}php

namespace App\DataTables\{{ $gen->modelClassName() }};

use App\Models\{{ $gen->modelClassName() }};
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class {{ $gen->modelClassName() }}DataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('id', function( $query ){
            return $query->id;
        })
<?php foreach ($fields as $field) { ?>
<?php if (!\Nvd\Crud\Db::isGuarded($field->name)) { ?>
<?php if (preg_match("/email/", $field->name)) { ?>
        ->addColumn('{{$field->name}}', function( $query ){
            return '<a href="mailto:'. $query->{{$field->name}} .'" class="text-black">'. $query->{{$field->name}} .'</a>';
        })
<?php } else { ?>
        ->addColumn('{{$field->name}}', function( $query ){
            if( $query->{{$field->name}} ){
                return $query->{{$field->name}};
            }
            return 'N/A';
        })
<?php } ?>

<?php } ?>
<?php } ?>
        ->addColumn('created_at', function( $query ){
            if( $query->created_at ){
                return $query->created_at->toFormattedDateString();
            }
            return 'N/A';
        })
        ->addColumn('action', function( $query ){
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
        ->rawColumns(['{{ join("', '", collect($fields)->pluck('name')->all()) }}']);
    }

    public function query({{ $gen->modelClassName() }} $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
<?php foreach ($fields as $field) { ?>
            ->addColumn([ 'data' => '{{ $field->name }}', 'title' => '{{ ucwords(str_replace("_", " ", $field->name)) }}' ])
<?php } ?>
            ->minifiedAjax()
            ->addAction(['width' => '140px'])
            ->parameters();
    }

    protected function filename()
    {
        return '{{ $gen->modelClassName() }}\{{ $gen->modelClassName() }}_' . date('YmdHis');
    }
}
