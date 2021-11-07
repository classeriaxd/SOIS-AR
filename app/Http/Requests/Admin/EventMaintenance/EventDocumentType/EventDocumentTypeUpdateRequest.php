<?php

namespace App\Http\Requests\Admin\EventMaintenance\EventDocumentType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventDocumentTypeUpdateRequest extends FormRequest
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
            'documentType' => 'required|string|unique:App\Models\EventDocumentType,document_type,' . $this->document_type_id,
            'helper' => 'sometimes|string',
        ];
        return $rules;
    }
}
