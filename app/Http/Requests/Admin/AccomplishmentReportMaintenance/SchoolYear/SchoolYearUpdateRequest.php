<?php

namespace App\Http\Requests\Admin\AccomplishmentReportMaintenance\SchoolYear;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SchoolYear;

class SchoolYearUpdateRequest extends FormRequest
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
        $schoolYear = SchoolYear::where('school_year_id', $this->school_year_id)->first();
        $dataStartCap = Carbon::parse($schoolYear->year_start . '-01-01')->format('Y-m-d');
        $dataEndCap = Carbon::parse($schoolYear->year_end . '-12-31')->format('Y-m-d');

        $rules = [
            'firstSemesterStart' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap,
            'firstSemesterEnd' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap.'|after_or_equal:firstSemesterStart',
            'secondSemesterStart' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap.'|after_or_equal:firstSemesterEnd',
            'secondSemesterEnd' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap.'|after_or_equal:secondSemesterStart',
            'summerTermStart' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap.'|after_or_equal:secondSemesterEnd',
            'summerTermEnd' => 'required|date|after_or_equal:'.$dataStartCap.'|before_or_equal:'.$dataEndCap.'|after_or_equal:summerTermStart',
        ];
        return $rules;
    }
}
