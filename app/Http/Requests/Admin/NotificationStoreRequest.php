<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\NotificationOrganizationRecieverStoreRule;

class NotificationStoreRequest extends FormRequest
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
        $acceptedRecievers = ['All', 'Officers', 'Presidents'];
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'organization' => ['required', 'array', new NotificationOrganizationRecieverStoreRule()],
            'reciever' => ['required', 'string', Rule::in($acceptedRecievers)],
        ];
        return $rules;
    }
}
