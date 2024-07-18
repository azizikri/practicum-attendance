<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && Gate::authorize('isAdmin', auth()->user());
    }

    protected function prepareForValidation()
    {
        $isFromAssistantOrStudentRoute = in_array(Route::currentRouteName(), ['admin.assistants.store', 'admin.students.store', 'admin.assistants.update', 'admin.students.update']);

        if ($this->isMethod('patch')) {
            $data = ['name', 'password'];

            if ($isFromAssistantOrStudentRoute) {
                $data[] = 'npm';
            } else {
                $data[] = 'email';
            }

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $isFromAssistantOrStudentRoute = in_array(Route::currentRouteName(), ['admin.assistants.store', 'admin.students.store', 'admin.assistants.update', 'admin.students.update']);

        $rules = [
            'name' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];

        if ($isFromAssistantOrStudentRoute) {
            $rules['npm'] = [
                $this->isMethod('POST') ? 'required' : 'sometimes',
                'numeric',
                'digits:8',
                Rule::unique(User::class)
                    ->where(function ($query) {
                        return $query->where('role', $this->input('role'));
                    })
                    ->ignore($this->user)
            ];
        } else {
            $rules['email'] = [$this->isMethod('POST') ? 'required' : 'sometimes', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user)];
        }

        return $rules;
    }
}
