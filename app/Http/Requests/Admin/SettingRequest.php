<?php

namespace App\Http\Requests\Admin;

use App\Enums\AcademicPeriod;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && Gate::authorize('isAdmin', auth()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academic_year' => ['required', 'string', 'regex:/^\d{4}\/\d{4}$/'],
            'academic_period' => ['required', new EnumValue(AcademicPeriod::class)],
        ];
    }
}
