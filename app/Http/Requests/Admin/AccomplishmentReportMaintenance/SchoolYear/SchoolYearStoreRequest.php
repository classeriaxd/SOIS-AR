<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\SchoolYear;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SchoolYearStoreRequest extends FormRequest
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
            'addYearWithSelect' => 'required_without:addYearWithCustom',
            'addYearSelect' => 'required_with:addYearWithSelect|integer|digits:1|min:1|max:5',

            'addYearWithCustom' => 'required_without:addYearWithSelect',
            'addYearCustom' => 'required_with:addYearWithCustom|integer|min:1992|max:2100|unique:App\Models\SchoolYear,year_start',
        ];
        
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'addYearSelect' => 'year',
            'addYearCustom' => 'year',
        ];
    }
}
