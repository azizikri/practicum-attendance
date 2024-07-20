<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Rules\CheckRole;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ClassStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return auth()->check() && Gate::authorize('isAdmin', auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'students' => ['required', 'array'],
            'students.*' => ['exists:users,id', new CheckRole(UserRole::Student)],
        ];
    }
}
