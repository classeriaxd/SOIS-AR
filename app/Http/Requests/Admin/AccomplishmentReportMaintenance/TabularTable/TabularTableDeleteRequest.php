<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\TabularTable;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\TabularTable;

class TabularTableDeleteRequest extends FormRequest
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
        $tabularTableName = TabularTable::where('tabular_table_id', $this->tabular_table_id)->value('tabular_table_name');
        $rules = [
            'verification' => 'required|string|in:' . $tabularTableName,
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
