<?php

namespace App\Http\Requests\Admin\EventMaintenance\EventNature;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventNatureStoreRequest extends FormRequest
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
            'nature' => 'required|string|unique:App\Models\EventNature,nature',
            'helper' => 'sometimes|string',
        ];
        return $rules;
    }
}
