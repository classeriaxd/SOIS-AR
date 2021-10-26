<?php

namespace App\Http\Requests\Admin\EventMaintenance\EventRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\EventRole;

class EventRoleDeleteRequest extends FormRequest
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
        $role = EventRole::where('event_role_id', $this->role_id)->value('event_role');
        $rules = [
            'verification' => 'required|string|in:' . $role,
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
