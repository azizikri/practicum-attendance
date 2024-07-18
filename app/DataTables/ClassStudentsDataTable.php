<?php

namespace App\DataTables;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;


class ClassStudentsDataTable extends DataTable
{
    protected string $dataTableVariable = 'dataTableClassStudents';
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
                    <div class="d-flex align-items-center">
                        <form action="' . route('admin.classes.students.delete', $row->id) . '" method="post">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" onclick="return confirm(\'Apakah Anda Yakin?\')" class="mr-2 btn btn-sm btn-danger btn-icon-text">
                                Hapus
                            </button>
                        </form>
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
    public function query(User $model) : QueryBuilder
    {
        return $model->newQuery()->whereRole(UserRole::Student)->where('class_id', $this->class->id)->orderBy('name');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() : HtmlBuilder
    {
        return $this->builder()
            ->setTableId('class-student-table')
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
        return 'Classes_Students' . date('YmdHis');
    }
}
