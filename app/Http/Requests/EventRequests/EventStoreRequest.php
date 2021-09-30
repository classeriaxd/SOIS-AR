<?php

namespace App\Http\Requests\EventRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EventStoreRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:250',
            'description' => 'required|string',
            'objective' => 'required|string',
            'startDate' => 'required|date|date_format:Y-m-d|before_or_equal:now|after:1992-01-01',
            'endDate' => 'required|date|date_format:Y-m-d|after_or_equal:startDate|before_or_equal:now|after:1992-01-01',
            'startTime' => 'date_format:H:i',
            'endTime' => 'date_format:H:i|after_or_equal:startTime',
            'venue' => 'required|string|min:2|max:250',
            'activityType' => 'required|string|min:2|max:250',
            'beneficiaries' => 'required|string|min:2|max:250',
            'totalBeneficiary' => 'required|integer|min:1',
            'sponsors' => 'required|string|min:2|max:250',
            'budget' => 'nullable|numeric',
            'eventRole' => 'required|integer|exists:event_roles,event_role_id',
            'eventCategory' => 'required|integer|exists:event_categories,event_category_id',
            'fundSource' => 'required|integer|exists:fund_sources,fund_source_id',
            'level' => 'required|integer|exists:levels,level_id',

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
            'startDate' => 'start date',
            'endDate' => 'end date',
            'startTime' => 'start time',
            'endTime' => 'end time',
            'fundSource' => 'fund source',
            'eventRole' => 'event role',
            'eventCategory' => 'event category',
            'totalBeneficiary' => 'total beneficiaries',
        ];
    }
}
