<?php

namespace App\Http\Requests\StudentAccomplishmentRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StudentAccomplishmentApproveRequest extends FormRequest
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
            'remarks' => 'required|string',
            'level' => 'required|integer|exists:App\Models\Level,level_id',
            'fundSource' => 'required|integer|exists:App\Models\FundSource,fund_source_id',
            'budget' => 'sometimes|nullable|integer',
            'relatedEvent' => 'sometimes|nullable|integer|exists:App\Models\Event,accomplished_event_id',
            'beneficiaries' => 'required|string',
            'activityType' => 'required|string',

            'documentType1' => 'sometimes|integer|exists:App\Models\studentAccomplishmentDocumentTypes,SA_document_type_id',
            'documentType2' => 'sometimes|integer|exists:App\Models\studentAccomplishmentDocumentTypes,SA_document_type_id',
            'documentType3' => 'sometimes|integer|exists:App\Models\studentAccomplishmentDocumentTypes,SA_document_type_id',
            'success' => 'required_without:decline',
            'decline' => 'required_without:success',
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
            'activityType' => 'activity type',
            'relatedEvent' => 'related event',
        ];
    }
}
