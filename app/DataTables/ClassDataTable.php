<?php

namespace App\DataTables;

use App\Models\ClassModel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ClassDataTable extends DataTable
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

            ->addColumn('jumlah_mahasiswa', function ($row) {
                return $row->students_count;
            })


            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="gap-3 d-flex align-items-center">
                        <a href="' . route('admin.classes.show', $row->id) . '" class="text-info">
                            <button type="button" class="btn btn-sm btn-info btn-icon-text">
                                Details
                            </button>
                        </a>

                        <a href="' . route('admin.classes.edit', $row->id) . '" class="text-info">
                            <button type="button" class="btn btn-sm btn-warning btn-icon-text">
                                Edit
                            </button>
                        </a>

                        <button
                            type="button"
                            class="btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.classes.destroy', $row->id) . '"
                            data-title="Apakah anda ingin menghapus kelas ' . $row->name . '?">
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
     * @param \App\Models\ClassModel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ClassModel $model) : QueryBuilder
    {
        return $model->newQuery()->withCount(['students'])->orderBy('name');
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
            Column::make('jumlah_mahasiswa'),
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
        return 'Classes_' . date('YmdHis');
    }
}
