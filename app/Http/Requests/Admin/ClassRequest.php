<?php

namespace App\Http\Requests\Admin;

use App\Models\ClassModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    public function authorize() : bool
    {
        return auth()->check() && Gate::authorize('isAdmin', auth()->user());
    }

    protected function prepareForValidation()
    {
        if ($this->isMethod('patch')) {
            $data = ['name'];

            foreach ($data as $key) {
                if ($this->input($key) === null) {
                    $this->request->remove($key);
                }
            }

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'name' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'string', Rule::unique(ClassModel::class)->ignore($this->class)]
        ];
    }
}
