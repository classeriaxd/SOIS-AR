<?php

namespace App\Http\Requests\AccomplishmentReportRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FinalizeReportRequest extends FormRequest
{
    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = "accomplishmentreports.create";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check())
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $range_title_array = ['Semestral', 'Quarterly', 'Custom'];
        $rules = [
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'end_date' => 'required|date|date_format:Y-m-d|after_or_equal:start_date|after:1992-01-01',
            'ar_format' => 'required|integer|exists:App\Models\AccomplishmentReportType,accomplishment_report_type_id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'range_title' => ['required','string', Rule::in($range_title_array),],
            'organizationDocuments.*' => 'sometimes|integer',
        ];
        return $rules;
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_date.required' => 'Missing: Start Date',
            'end_date.required' => 'Missing: End Date',
            'range_title.required' => 'Missing: Range Title',
            'range_title.in_array' => 'Unknown: Range Title',
            'ar_format.required' => 'Missing: AR Format',
            'ar_format.exists' => 'Format Error',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'start_date' => 'start date',
            'end_date' => 'end date',
            'ar_format' => 'Accomplishment Report format',
            'range_title' => 'range title',
        ];
    }
}
