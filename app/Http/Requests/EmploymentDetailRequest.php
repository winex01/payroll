<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Models\EmploymentDetail;
use App\Models\EmploymentDetailType;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Admin\Traits\StrTrait;

class EmploymentDetailRequest extends FormRequest
{
    use StrTrait;

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
            'employmentDetailType' => 'required|exists:employment_detail_types,id',
            'effectivity_date' => 'required|date|after_or_equal:today',
        ];

        // TODO:: remove this if we finalize that we allow employee and type to be editable
        /* if (request('employmentDetailType')) {
            $type = EmploymentDetailType::findOrFail(request('employmentDetailType'));
            if ($type) {
                $field = Str::snake($type->name);
                $rules[$field] = $type->validation;
            }
        }
        // in edit, dont allow to edit employee select field and employmentType select field
        if (request()->method() == 'PUT' && request('id')) {
            $entry = EmploymentDetail::findOrFail(request('id'));
            $rules['employee'] = 'required|in:' . $entry->employee_id . '|exists:employees,id';
            $rules['employmentDetailType'] = 'required|in:' . $entry->employment_detail_type_id . '|exists:employment_detail_types,id';
        } */

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
