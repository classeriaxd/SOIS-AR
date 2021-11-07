<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\TabularColumn;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\TabularColumn;

class TabularColumnDeleteRequest extends FormRequest
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
        $tabularColumnName = TabularColumn::where('tabular_column_id', $this->tabular_column_id)->value('tabular_column_name');
        $rules = [
            'verification' => 'required|string|in:' . $tabularColumnName,
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
