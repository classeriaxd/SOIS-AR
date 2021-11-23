<?php

namespace App\Http\Requests\StudentAccomplishmentRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StudentAccomplishmentStoreRequest extends FormRequest
{
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
        $rules = [
            'title' => 'required|string',
            'description' => 'required|string',
            'objective' => 'required|string',
            'organizer' => 'required|string|min:2|max:250',
            'venue' => 'required|string|min:2|max:250',
            'organizer' => 'required|string|min:2|max:250',
            'startDate' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'endDate' => 'required|date|date_format:Y-m-d|after_or_equal:startDate|before_or_equal:now|after:1992-01-01',
            'startTime' => 'date_format:H:i',
            'endTime' => 'date_format:H:i|after_or_equal:startTime',
            'evidence1' => 'required|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/|string',
            'evidence2' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/|string',
            'evidence3' => 'nullable|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/|string',
            'caption1' => 'nullable|string',
            'caption2' => 'nullable|string',
            'caption3' => 'nullable|string',

            'documentType1' => 'required|numeric|exists:App\Models\StudentAccomplishmentDocumentType,SA_document_type_id',
            'documentType2' => 'required_with:evidence2|numeric|exists:App\Models\StudentAccomplishmentDocumentType,SA_document_type_id',
            'documentType3' => 'required_with:evidence3|numeric|exists:App\Models\StudentAccomplishmentDocumentType,SA_document_type_id',
        ];
        return $rules;
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'startDate' => 'start date',
            'endDate' => 'end date',
            'startTime' => 'start time',
            'endTime' => 'end time',
            'evidence1' => 'evidence 1',
            'evidence2' => 'evidence 2',
            'evidence3' => 'evidence 3',
            'documentType1' => 'document type 1',
            'documentType2' => 'document type 2',
            'documentType3' => 'document type 3',
        ];
    }
}
