<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelationRequest extends FormRequest
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
            'relation.employee' => 'required|exists:employees,id',
            'relation.relationship' => 'required|exists:relationships,id',
            'relation.last_name' => 'required|string|min:2|max:255',
            'relation.first_name' => 'required|string|min:2|max:255',
            'relation.middle_name' => 'nullable|string|min:2|max:255',
            'relation.birth_date' => 'nullable|date',
            'relation.address' => 'required|string|min:10|max:255',
            // 'relation.contact_no' => 'nullable|phone:INTERNATIONAL,PH',
            // 'relation.contact_no' => [
            //     'nullable',
            //     'regex:/^(?:\+63|0)(\d{9,10})$/',
            // ],
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
            'relation.employee' => 'employee',
            'relation.relationship' => 'relationship',
            'relation.last_name' => 'last name',
            'relation.first_name' => 'first name',
            'relation.middle_name' => 'middle name',
            'relation.birth_date' => 'birth date',
            // 'relation.contact_no' => 'contact no',
            'relation.address' => 'address',
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
            // 'relation.contact_no' => 'The :attribute must be a valid mobile or landline number.'
        ];
    }
}
