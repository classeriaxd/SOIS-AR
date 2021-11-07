<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\TabularColumn;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Rules\TabularColumnNameUpdateRule;

class TabularColumnUpdateRequest extends FormRequest
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
            'tabularColumnName' => ['required', 'string', new TabularColumnNameUpdateRule($this->tabular_table_id, $this->tabular_column_id)],
            'description' => 'sometimes|nullable|string',
        ];
        return $rules;
    }
}
