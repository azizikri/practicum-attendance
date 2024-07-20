<?php

namespace App\DataTables;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ScheduleDataTable extends DataTable
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
            ->addColumn('mata_praktikum', function ($row) {
                return $row->class_subject_name;
            })
            ->filterColumn('mata_praktikum', function ($query, $keyword) {
                $query->where('class_subject_name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('pj', function ($row) {
                return $row->pj_name;
            })
            ->filterColumn('pj', function ($query, $keyword) {
                $query->where('pj_name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('tahun_akademik', function ($row) {
                return $row->academic_year;
            })
            ->filterColumn('tahun_akademik', function ($query, $keyword) {
                $query->where('academic_year', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('periode_akademik', function ($row) {
                return strtoupper($row->academic_period);
            })
            ->filterColumn('periode_akademik', function ($query, $keyword) {
                $query->where('academic_period', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('lokasi', function ($row) {
                return $row->location;
            })
            ->filterColumn('lokasi', function ($query, $keyword) {
                $query->where('location', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('hari', function ($row) {
                return ucfirst($row->day);
            })
            ->filterColumn('hari', function ($query, $keyword) {
                $query->where('day', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('shift', function ($row) {
                return $row->shift;
            })
            ->filterColumn('shift', function ($query, $keyword) {
                $query->where('shift', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('pertemuan', function ($row) {
                return $row->session;
            })
            ->filterColumn('pertemuan', function ($query, $keyword) {
                $query->where('session', 'like', ["%{$keyword}%"]);
            })



            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="d-flex align-items-center">

                        <a href="' . route('admin.schedules.edit', $row->id) . '" class="mx-3 text-info">
                            <button type="button" class="btn btn-sm btn-dark btn-icon-text">
                                Selsaikan Pertemuan
                            </button>
                        </a>

                        <a href="' . route('admin.schedules.edit', $row->id) . '" class="text-info">
                            <button type="button" class="btn btn-sm btn-warning btn-icon-text">
                                Edit
                            </button>
                        </a>

                        <a href="' . route('admin.schedules.show', $row->id) . '" class="mx-3 text-info">
                            <button type="button" class="btn btn-sm btn-info btn-icon-text">
                                Details
                            </button>
                        </a>

                        <button
                            type="button"
                            class="mr-2 btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.schedules.destroy', $row->id) . '"
                            data-title="Apakah anda ingin menghapus jadwal ' . $row->name . '?">
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
     * @param \App\Models\Schedule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Schedule $model) : QueryBuilder
    {
        return $model->newQuery()->where('academic_year', settings()->get('academic_year'))->orWhere('academic_period', settings()->get('academic_period'))->orderBy('academic_period');
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
            Column::make('mata_praktikum'),
            Column::make('pj'),
            Column::make('tahun_akademik'),
            Column::make('periode_akademik'),
            Column::make('lokasi'),
            Column::make('hari'),
            Column::make('shift'),
            Column::make('pertemuan'),

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
        return 'Schedule_' . date('YmdHis');
    }
}
