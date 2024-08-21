<?php

namespace App\DataTables;

use App\Models\Attendance;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Exports\AttendancesExport;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class AttendanceDataTable extends DataTable
{
    protected string $dataTableVariable = 'dataTableAttendances';
    // protected $exportClass = AttendancesExport::class;

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query) : EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('kelas', function ($row) {
                return $row->schedule_class_subject_name;
            })
            ->filterColumn('kelas', function ($query, $keyword) {
                $query->where('schedule_class_subject_name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('asisten', function ($row) {
                return $row->assistant_name;
            })
            ->filterColumn('asisten', function ($query, $keyword) {
                $query->where('assistant_name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('praktikan', function ($row) {
                return $row->student_name;
            })
            ->filterColumn('praktikan', function ($query, $keyword) {
                $query->where('student_name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('waktu_absen', function ($row) {
                return $row->created_at;
            })
            ->filterColumn('waktu_absen', function ($query, $keyword) {
                $query->where('created_at', 'like', ["%{$keyword}%"]);
            })


            ->addColumn('action', function ($row) {
                return
                    '
                    <div class="gap-3 d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.attendances.destroy', $row->id) . '"
                            data-title="Apakah anda ingin menghapus absen ' . $row->student_name . ' di kelas ' . $row->schedule_class_subject_name . '">
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
    public function query(Attendance $model) : QueryBuilder
    {
        $query = $model->newQuery();

        if ($this->schedule != null) {
            $query->whereBelongsTo($this->schedule);
        }

        return $query->orderBy('session', 'desc')->orderBy('created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() : HtmlBuilder
    {
        $builder = $this->builder()
            ->setTableId('attendance-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();

        if ($this->schedule != null) {
            $builder->buttons([
                Button::make('excel')->action('function() { window.location = "' . route('admin.attendances.export', ['schedule' => $this->schedule]) . '"; }')
            ]);
        }

        return $builder;
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns() : array
    {
        return [
            Column::make('kelas'),
            Column::make('asisten'),
            Column::make('praktikan'),
            Column::make('waktu_absen'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename() : string
    {
        return 'Attendance_' . date('YmdHis');
    }
}
