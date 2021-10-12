<?php

namespace App\Http\Requests\EventImageRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventImageStoreRequest extends FormRequest
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
            'poster.*' => 'required_without:evidence|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/|string',
            'evidence.*' => 'required_without:evidence|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/|string',
        ];
        return $rules;
    }
}
