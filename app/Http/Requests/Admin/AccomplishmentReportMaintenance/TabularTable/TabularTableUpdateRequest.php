<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\TabularTable;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Rules\TabularColumnNameUpdateRule;

class TabularTableUpdateRequest extends FormRequest
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
            'tabularTableName' => 'required|string|unique:App\Models\TabularTable,tabular_table_name, ' . $this->tabular_table_id,
            'description' => 'sometimes|nullable|string',
            'referenceTableNumber' => 'sometimes|nullable|integer',
        ];
        return $rules;
    }
}
