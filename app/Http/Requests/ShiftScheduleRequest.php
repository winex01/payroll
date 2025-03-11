<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\ValidateUniqueTrait;

class ShiftScheduleRequest extends FormRequest
{
    use ValidateUniqueTrait;

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
        $rules = $this->validateUnique(table: 'shift_schedules');
        $openTime = $this->input('open_time');

        $rules = array_merge($rules, [
            'open_time' => 'boolean',
            'early_login_overtime' => 'boolean',
            'after_shift_overtime' => 'boolean',
            'night_differential' => 'boolean',
            'late' => 'boolean',
            'undertime' => 'boolean',
            'description' => 'nullable|string',

            'day_start' => $openTime ? 'nullable|integer|between:1,5' : 'required|integer|between:1,5',

            // Apply conditional validation for working_hours based on open_time
            'working_hours' => $openTime ? 'nullable|array' : 'required|array', // since we convert the json field in prepareForValidation method we use array here
            'working_hours.*.start' => $openTime ? 'nullable|date_format:H:i' : 'required|date_format:H:i',
            'working_hours.*.end' => $openTime ? 'nullable|date_format:H:i' : 'required|date_format:H:i',
        ]);

        // dd(request()->all());

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'working_hours' => json_decode($this->input('working_hours'), true),
        ]);
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
            'working_hours.json' => 'The working hours field must contain valid time entries.',
            'working_hours.*.start.required' => 'The start time is required for each working hour.',
            'working_hours.*.end.required' => 'The end time is required for each working hour.',
        ];
    }
}
