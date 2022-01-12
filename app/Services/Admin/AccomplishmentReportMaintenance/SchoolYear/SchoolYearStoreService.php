<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\SchoolYear;

use App\Models\SchoolYear;
use Carbon\Carbon;

class SchoolYearStoreService
{
    /**
     * @param Request $request
     * Service to Store a School Year.
     * Returns Message on success
     * @return Array
     */
    public function store($request): array
    {
        try 
        {
            if ($request->has('addYearWithSelect')) 
            {
                $latestSchoolYear = SchoolYear::orderBy('year_start', 'DESC')->first();
                for ($i=1; $i <= $request->input('addYearSelect'); $i++) 
                { 
                    if(SchoolYear::where('year_start', $latestSchoolYear->year_start + $i)->exists())
                        continue;

                    $start_year = $latestSchoolYear->year_start + $i;
                    $end_year = $start_year + 1;
                    
                    $this->createSchoolYear($start_year, $end_year);
                }
            }

            else if($request->has('addYearWithCustom'))
            {
                $start_year = $request->input('addYearCustom');
                $end_year = $start_year + 1;
                
                $this->createSchoolYear($start_year, $end_year);
            }
                
            return ['success' => 'Added the School Year successfully!'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in adding School Year: ' . $e->getMessage()];
        }
    }

    /**
     * @param Integer $start_year, Integer $end_year
     * Function to create School Year
     */ 
    private function createSchoolYear($start_year, $end_year)
    {
        // First Semester starts on October
        $first_semester_start = Carbon::createFromDate($start_year)->startOfYear()->addMonths(9)->firstOfMonth();
        // First Semester ends on February
        $first_semester_end = Carbon::createFromDate($first_semester_start)->addWeeks(21)->endOfMonth();

        // Second Semester starts on March
        $second_semester_start = Carbon::createFromDate($first_semester_end)->addMonth()->startOfMonth();
        // Second Semester ends on July
        $second_semester_end = Carbon::createFromDate($second_semester_start)->addMonths(4)->endOfMonth();

        // Summer Term starts on August
        $summer_term_start = Carbon::createFromDate($second_semester_end)->addMonth()->startOfMonth();
        // Summer Term ends on September
        $summer_term_end = Carbon::createFromDate($summer_term_start)->addMonth()->endOfMonth();

        // Annual Start and End based on First Semester and Summer Term
        $annual_start = $first_semester_start;
        $annual_end = $summer_term_end;

        SchoolYear::create([
            'year_start' => $start_year,
            'year_end' => $end_year,
            'first_semester_start' => $first_semester_start,
            'first_semester_end' => $first_semester_end,
            'second_semester_start' => $second_semester_start,
            'second_semester_end' => $second_semester_end,
            'summer_term_start' => $summer_term_start,
            'summer_term_end' => $summer_term_end,
            'annual_start' => $annual_start,
            'annual_end' => $annual_end,
        ]);
    }
}
