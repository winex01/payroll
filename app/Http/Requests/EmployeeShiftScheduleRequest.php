<?php

namespace App\Http\Requests;

use App\Http\Controllers\Admin\Traits\CalendarTrait;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeShiftScheduleRequest extends FormRequest
{
    use CalendarTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'employee' => 'required|exists:employees,id',
            'effectivity_date' => 'required|date|after_or_equal:today',
        ];

        foreach ($this->daysOfWeek() as $day) {
            $rules[$day] = 'nullable|exists:shift_schedules,id';
        }

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
