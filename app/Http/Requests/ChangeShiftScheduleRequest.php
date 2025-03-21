<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChangeShiftScheduleRequest extends FormRequest
{
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
            'date' => [
                'required',
                'date',
                Rule::unique('change_shift_schedules', 'date')
                    ->where(function ($query) {
                        return $query->where('employee_id', $this->employee);
                    })
                    ->ignore($this->id ?? null), // Ignore current record during update
            ],
            'shiftSchedule' => 'nullable|exists:shift_schedules,id',
        ];

        // Only enforce 'after_or_equal:today' if user does NOT have 'backdating' permission
        if (!backpack_user()->can('change_shift_schedules_backdating')) {
            $rules['date'][] = 'after_or_equal:today';
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
