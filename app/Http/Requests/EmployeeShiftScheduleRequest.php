<?php

namespace App\Http\Requests;

use App\Traits\HelperTrait;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeShiftScheduleRequest extends FormRequest
{
    use HelperTrait;

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
            'effectivity_date' => [
                'required',
                'date',
                Rule::unique('employee_shift_schedules', 'effectivity_date')
                    ->where(function ($query) {
                        return $query->where('employee_id', $this->employee);
                    })
                    ->ignore($this->id ?? null), // Ignore current record during update
            ],
        ];

        // Only enforce 'after_or_equal:today' if user does NOT have 'backdating' permission
        if (!backpack_user()->can('employee_shift_schedules_backdating')) {
            $rules['effectivity_date'][] = 'after_or_equal:today';
        }

        foreach ($this->daysOfWeek() as $day) {
            $rules[$day] = 'required|exists:shift_schedules,id';
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
            'effectivity_date.unique' => __('app.duplicate_entry'),
        ];
    }
}
