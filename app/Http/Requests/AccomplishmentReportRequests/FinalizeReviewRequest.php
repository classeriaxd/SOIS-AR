<?php

namespace App\Http\Requests\AccomplishmentReportRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FinalizeReviewRequest extends FormRequest
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
            'remarks' => 'required|string',
            'archive' => 'sometimes|accepted',
            'esignature' => 'sometimes|accepted',
            'success' => 'sometimes|string',
            'decline' => 'sometimes|string',
        ];
        return $rules;
    }
}
