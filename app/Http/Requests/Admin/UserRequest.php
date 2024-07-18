<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
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
        if ($this->isMethod('patch')) {
            $data = ['name', 'email', 'password'];

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
        return [
            'name' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'string', 'max:255'],
            'email' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}

