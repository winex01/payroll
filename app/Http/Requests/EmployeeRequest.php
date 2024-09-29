<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        return [
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employee_no' => 'nullable|unique:employees,employee_no,' . (request()->id ? request()->id : 'NULL'),
            'last_name' => 'required|string|min:2|max:255',
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|min:2|max:255',

            'gender' => 'required|exists:genders,id',

            'mobile_no' => 'nullable|phone:INTERNATIONAL,PH',
            'telephone_no' => 'nullable|string',
            'personal_email' => 'nullable|email',
            'company_email' => 'nullable|email',

            'civilStatus' => 'required|exists:civil_statuses,id',
            'current_address' => 'required|string|min:10|max:255',

            'birth_date' => 'nullable|date',
            'date_of_marriage' => 'nullable|date',

        ];
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
            'mobile_no' => 'The :attribute field must be a valid number.',
        ];
    }
}
