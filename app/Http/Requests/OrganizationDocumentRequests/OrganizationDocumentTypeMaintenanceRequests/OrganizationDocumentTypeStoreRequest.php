<?php

namespace App\Http\Requests\OrganizationDocumentRequests\OrganizationDocumentTypeMaintenanceRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Rules\OrganizationDocumentTypeStoreRule;

class OrganizationDocumentTypeStoreRequest extends FormRequest
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
            'documentType' => ['required', 'string', new OrganizationDocumentTypeStoreRule($this->organizationSlug)],
        ];
        return $rules;
    }
}
