<?php

namespace App\Http\Requests\Admin\EventMaintenance\EventDocumentType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\EventDocumentType;

class EventDocumentTypeDeleteRequest extends FormRequest
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
        $documentType = EventDocumentType::where('event_document_type_id', $this->document_type_id)->value('document_type');
        $rules = [
            'verification' => 'required|string|in:' . $documentType,
            'notificationTitle' => 'required|string|max:255',
            'notificationDescription' => 'required|string',
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
            'verification.in' => 'Incorrect verification',
        ];
    }
}
