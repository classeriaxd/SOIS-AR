<?php

namespace App\Http\Requests\Admin\UserMaintenance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Role;

class UserRoleAttachRequest extends FormRequest
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
        $attachableRolesForAR = ['AR Officer Admin', 'AR President Admin'];
        $roles = (Role::whereIn('role', $attachableRolesForAR)->pluck('role_id'))->flatten()->toArray();
        $rules = [
            'role' => [
                'required',
                'integer',
                Rule::in($roles),
                'exists:App\Models\Role,role_id'],
            'organization' => 'required|integer|exists:App\Models\Organization,organization_id',
        ];
        return $rules;
    }
}
