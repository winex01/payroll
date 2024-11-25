<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class NewHireRequest extends FormRequest
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

    public function rules(): array
    {
        $rules = [
            'employee' => 'required|exists:employees,id',
            'effectivity_date' => 'required|date|after_or_equal:today',
        ];

        $types = \App\Models\EmploymentDetailType::all();

        foreach ($types as $type) {
            $fieldName = Str::snake($type->name);
            $rules[$fieldName] = $type->validation;
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
