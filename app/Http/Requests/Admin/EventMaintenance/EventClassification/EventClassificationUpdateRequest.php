<?php

namespace App\Http\Requests\Admin\EventMaintenance\EventClassification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventClassificationUpdateRequest extends FormRequest
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
            'classification' => 'required|string|unique:App\Models\EventClassification,classification,' . $this->classification_id,
            'helper' => 'sometimes|string',
        ];
        return $rules;
    }
}
