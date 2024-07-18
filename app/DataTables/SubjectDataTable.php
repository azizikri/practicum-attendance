<?php

namespace App\DataTables;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubjectDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query) : EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('nama', function ($row) {
                return $row->name;
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('singkatan', function ($row) {
                return $row->short_name;
            })
            ->filterColumn('singkatan', function ($query, $keyword) {
                $query->where('short_name', 'like', ["%{$keyword}%"]);
            })


            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="d-flex align-items-center">
                        <a href="' . route('admin.subjects.edit', $row->id) . '" class="mx-3 text-info">
                            <button type="button" class="btn btn-sm btn-warning btn-icon-text">
                                Edit
                            </button>
                        </a>

                        <button
                            type="button"
                            class="mr-2 btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.subjects.destroy', $row->id) . '">
                                Hapus
                        </button>
                    </div>
                ';
            })

            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Subject $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subject $model) : QueryBuilder
    {
        return $model->newQuery()->orderBy('name');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() : HtmlBuilder
    {
        return $this->builder()
            ->setTableId('class-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([

                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns() : array
    {
        return [
            Column::make('nama'),
            Column::make('singkatan'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() : string
    {
        return 'Subject_' . date('YmdHis');
    }
}
