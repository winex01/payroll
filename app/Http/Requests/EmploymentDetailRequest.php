<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
            'effectivity_date' => [
                'required',
                'date',
                Rule::unique('employment_details', 'effectivity_date')
                    ->where(function ($query) {
                        return $query->where('employee_id', $this->employee)
                            ->where('employment_detail_type_id', $this->employmentDetailType);
                    })
                    ->ignore($this->id ?? null),
            ],
        ];

        // Only enforce 'after_or_equal:today' if user does NOT have 'backdating' permission
        if (!backpack_user()->can('employment_details_backdating')) {
            $rules['effectivity_date'][] = 'after_or_equal:today';
        }

        if (request('employmentDetailType')) {
            $type = EmploymentDetailType::findOrFail(request('employmentDetailType'));
            if ($type) {
                $field = Str::snake($type->name);
                $rules[$field] = $type->validation;
            }
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
