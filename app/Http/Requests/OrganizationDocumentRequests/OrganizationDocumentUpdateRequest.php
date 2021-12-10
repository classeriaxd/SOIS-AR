<?php

namespace App\Http\Requests\OrganizationDocumentRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrganizationDocumentUpdateRequest extends FormRequest
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
            'effective_date' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
        ];
        return $rules;
    }
}
