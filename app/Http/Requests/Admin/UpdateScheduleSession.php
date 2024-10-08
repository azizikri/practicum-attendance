<?php

namespace App\Http\Requests\Admin;

use App\Rules\CheckScheduleSession;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleSession extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return auth()->check() && (Gate::authorize('isAdmin', auth()->user()) || Gate::authorize('isAssistant', auth()->user()) || $this->schedule->pj_id == auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {
        return [
            'session' => ['required', 'numeric', new CheckScheduleSession($this->schedule)]
        ];
    }
}
