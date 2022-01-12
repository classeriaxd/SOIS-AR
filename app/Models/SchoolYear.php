<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SchoolYear extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'school_year_id';
    protected $table = 'school_years';
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['annual_range', 'first_semester_range', 'second_semester_range', 'summer_term_range'];

    /**
     * Format the Date Range of Annual
     * @return string
     */
    public function getAnnualRangeAttribute()
    {
        $annualRange = Carbon::parse($this->annual_start)->format('F d, Y') . 
            ' - ' .
            Carbon::parse($this->annual_end)->format('F d, Y');
        return $annualRange;
    }

    /**
     * Format the Date Range of First Semester
     * @return string
     */
    public function getFirstSemesterRangeAttribute()
    {
        $firstSemesterRange = Carbon::parse($this->first_semester_start)->format('F d, Y') . 
            ' - ' .
            Carbon::parse($this->first_semester_end)->format('F d, Y');
        return $firstSemesterRange;
    }

    /**
     * Format the Date Range of Second Semester
     * @return string
     */
    public function getSecondSemesterRangeAttribute()
    {
        $secondSemesterRange = Carbon::parse($this->second_semester_start)->format('F d, Y') . 
            ' - ' .
            Carbon::parse($this->second_semester_end)->format('F d, Y');
        return $secondSemesterRange;
    }

    /**
     * Format the Date Range of Summer Term
     * @return string
     */
    public function getSummerTermRangeAttribute()
    {
        $summerTermRange = Carbon::parse($this->summer_term_start)->format('F d, Y') . 
            ' - ' .
            Carbon::parse($this->summer_term_end)->format('F d, Y');
        return $summerTermRange;
    }
}
