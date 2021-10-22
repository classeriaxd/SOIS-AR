<?php

namespace App\Http\Requests\Admin\EventMaintenance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\EventCategory;

class EventCategoryUpdateRequest extends FormRequest
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
        $categoryID = EventCategory::where('event_category_id', $this->category_id)->value('event_category_id');
        $rules = [
            'category' => 'required|string|unique:App\Models\EventCategory,category,' . $categoryID,
            'helper' => 'sometimes|string',
            'background_color' => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
            'text_color' => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
        ];
        return $rules;
    }
}
