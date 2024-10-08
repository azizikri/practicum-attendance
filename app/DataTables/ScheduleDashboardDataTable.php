<?php

namespace App\DataTables;

use App\Enums\UserRole;
use App\Models\Schedule;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class ScheduleDashboardDataTable extends DataTable
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
                    <div class="gap-3 d-flex align-items-center">
                        <button
                                type="button"
                                class="btn btn-sm btn-info btn-icon-text"
                                data-bs-toggle="modal"
                                data-bs-target="#showQRModal"
                                data-route="' . route('admin.attendances.create', $row->id) . '"
                                data-title="QR Code ' . $row->class_subject_name . '">
                                    Tunjukkan QR
                        </button>' .
                    (in_array(auth()->user()->role, [UserRole::Admin]) || auth()->id() == $row->pj_id ?
                        '<div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Atur Pertemuan
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="' . route('admin.schedules.end-session', $row->id) . '">Selesaikan Pertemuan</a>
                            </div>
                        </div>
                        <a href="' . route('admin.schedules.show', $row->id) . '" class="text-warning">
                            <button type="button" class="btn btn-sm btn-warning btn-icon-text">
                                Details
                            </button>
                        </a>' : '') .
                    '
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
        /** @var \App\Models\User $user **/
        $user = auth()->user();

        $query = $model->newQuery();



        if (! $user->isAdmin()) {
            $query
                ->whereHas('assistants', function ($query) {
                    $query->where('users.id', auth()->id());
                })
                ->orWhere('pj_id', auth()->id());
        }

        $query->where('academic_year', settings()->get('academic_year'))
            ->where('academic_period', settings()->get('academic_period'));

        return $query->orderBy('academic_period');
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
