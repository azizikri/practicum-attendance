<?php

namespace App\Imports;

use App\Models\User;
use App\Enums\UserRole;
use App\Models\ClassModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, SkipsEmptyRows, SkipsOnFailure, SkipsOnError
{
    use Importable;
    public $failures = [], $errors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new User([
            'name' => $row['nama'],
            'npm' => $row['npm'],
            'email' => $row['npm'] . '@iflab.gunadarma.ac.id',
            'class_id' => ClassModel::where('name', $row['kelas'])->firstOrFail()->id,
            'password' => Hash::make($row['password']),
        ]);
    }

    public function rules() : array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            '*.nama' => ['required', 'string', 'max:255'],

            'npm' => ['required', 'numeric', 'digits:8', Rule::unique(User::class)->where(function ($query) {
                return $query->where('role', UserRole::Student);
            })],
            '*.npm' => ['required', 'numeric', 'digits:8', Rule::unique(User::class)->where(function ($query) {
                return $query->where('role', UserRole::Student);
            })],

            'kelas' => ['required', 'string', 'exists:classes,id'],
            '*.kelas' => ['required', 'string', 'exists:classes,id'],
        ];
    }
    public function chunkSize() : int
    {
        return 1000;
    }

    public function onFailure(Failure ...$failures)
    {
        $this->failures = array_merge($this->failures, $failures);
    }

    public function onError(\Throwable $e)
    {
        $this->errors = $e;
    }
}
