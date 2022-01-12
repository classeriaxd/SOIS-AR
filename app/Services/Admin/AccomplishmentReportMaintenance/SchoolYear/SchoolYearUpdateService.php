<?php

namespace App\Services\Admin\AccomplishmentReportMaintenance\SchoolYear;

use App\Models\SchoolYear;

class SchoolYearUpdateService
{
    /**
     * @param Collection $schoolYear, Request $request
     * Service to Update a School Year.
     * Returns Message on success
     * @return Array
     */
    public function update(SchoolYear $schoolYear, $request): array
    {
        try 
        {
            $schoolYear->update([
                'first_semester_start' => $request->input('firstSemesterStart'),
                'first_semester_end' => $request->input('firstSemesterEnd'),
                'second_semester_start' => $request->input('secondSemesterStart'),
                'second_semester_end' => $request->input('secondSemesterEnd'),
                'summer_term_start' => $request->input('summerTermStart'),
                'summer_term_end' => $request->input('summerTermEnd'),
                'annual_start' => $request->input('firstSemesterStart'),
                'annual_end' => $request->input('summerTermEnd'),
            ]);

            return ['success' => 'Updated the School Year Successfully.'];
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            return ['error' => 'Error in Updating School Year:' . $e->getMessage()];
        }
            
    }
}
