<?php

namespace App\DataTables;

use App\Models\Subject;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ClassSubjectsDataTable extends DataTable
{
    protected string $dataTableVariable = 'dataTableClassSubjects';
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

            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="d-flex align-items-center">'.
                        ($row->currentScheduleId() != null ?
                        '<a href="' . route('admin.schedules.show', $row->currentScheduleId()) . '" class="mx-3 text-info">
                            <button type="button" class="btn btn-sm btn-info btn-icon-text">
                                Details
                            </button>
                        </a>' : '')
                        .'<button
                            type="button"
                            class="mr-2 btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.classes.subjects.delete', [$this->class->id, $row->id]) . '"
                            data-title="Apakah anda ingin menghapus mata praktikum '. $row->name .' dari kelas '. $this->class->name.'?">
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
        return $model->newQuery()->whereHas('classes', function($q){
            $q->where('classes.id', $this->class->id);
        })->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() : HtmlBuilder
    {
        return $this->builder()
            ->setTableId('class-subject-table')
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
        return 'Classes_Subjects' . date('YmdHis');
    }
}
