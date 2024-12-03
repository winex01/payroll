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

        $rules = array_merge($rules, [
            'open_time' => 'boolean',
            'early_login_overtime' => 'boolean',
            'after_shift_overtime' => 'boolean',
            'night_differential' => 'boolean',
            'working_hours' => 'required|json',
            'day_start' => 'required|date_format:H:i',
            'description' => 'nullable|string',
        ]);

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
