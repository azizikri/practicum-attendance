<?php

namespace App\Http\Requests\Admin;

use App\Enums\ScheduleDay;
use App\Enums\ScheduleLocation;
use App\Enums\ScheduleShift;
use App\Rules\CheckSchedule;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
    public function rules(): array
    {
        return [
            'class_subject_id' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'exists:class_subject,id', new CheckSchedule($this->schedule)],
            'pj_id' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'exists:users,id'],
            'location' => [$this->isMethod('POST') ? 'required' : 'sometimes', new EnumValue(ScheduleLocation::class)],
            'day' => [$this->isMethod('POST') ? 'required' : 'sometimes', new EnumValue(ScheduleDay::class)],
            'shift' => [$this->isMethod('POST') ? 'required' : 'sometimes', new EnumValue(ScheduleShift::class)],
            'total_session' => [$this->isMethod('POST') ? 'required' : 'sometimes', 'numeric'],
        ];
    }
}
