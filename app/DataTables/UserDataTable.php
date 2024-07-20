<?php

namespace App\DataTables;

use App\Models\User;
use App\Enums\UserRole;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query) : EloquentDataTable
    {
        $isAssistantOrStudent = in_array($this->role, [UserRole::Assistant, UserRole::Student]);

        $columns = (new EloquentDataTable($query))
            ->addColumn('nama', function ($row) {
                return $row->name;
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('name', 'like', ["%{$keyword}%"]);
            })

            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->where('email', 'like', ["%{$keyword}%"]);
            });

        if ($isAssistantOrStudent) {
            $columns = $columns->addColumn('npm', function ($row) {
                return $row->npm;
            })
                ->filterColumn('npm', function ($query, $keyword) {
                    $query->where('npm', 'like', ["%{$keyword}%"]);
                });
        }

        $columns->addColumn('action', function ($row) {
            return
                '
                <div class="d-flex align-items-center">
                    <a href="' . route('admin.' . $this->role . 's.edit', $row->id) . '" class="mx-3 text-info">
                        <button type="button" class="mr-3 btn btn-sm btn-warning btn-icon-text">
                            Edit
                        </button>
                    </a>

                    <button
                        type="button"
                            class="mr-2 btn btn-sm btn-danger btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-route="' . route('admin.' . $this->role . 's.destroy', $row->id) . '"
                            data-title="Apakah anda ingin menghapus '. $row->name .'?">
                        Hapus
                    </button>
                </div>
            ';
        })
            ->setRowId('id');

        return $columns;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model) : QueryBuilder
    {
        return $model->newQuery()->where('role', $this->role)->latest();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() : HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
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
        $isAssistantOrStudent = in_array($this->role, [UserRole::Assistant, UserRole::Student]);

        $columns = [
            Column::make('nama'),
            Column::make('email'),
        ];

        if ($isAssistantOrStudent) {
            $columns[] = Column::make('npm');
        }

        $columns[] = Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(150)
            ->addClass('text-center');

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() : string
    {
        return 'Users_' . date('YmdHis');
    }
}
