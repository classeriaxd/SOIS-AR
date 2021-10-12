<?php

namespace App\Http\Requests\EventDocumentRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventDocumentStoreRequest extends FormRequest
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
            'description' => 'nullable|string',
            'document_type' => 'required|exists:event_document_types,event_document_type_id',
            'document' => 'required|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
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
            'document_type' => 'document type',
        ];
    }
}
