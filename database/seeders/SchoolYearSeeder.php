<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start_year = '2020';
        $end_year = '2021';

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
        $annual_start = $first_semester_start;
        $annual_end = $summer_term_end;
        $data = [
            [
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
            ],
        ];
        DB::table('school_years')->insert($data);

        // // First Semester starts on First Monday of October
        // $first_semester_start = Carbon::createFromDate($start_year)->startOfYear()->addMonths(9)->firstOfMonth(Carbon::MONDAY);
        // // First Semester ends on Wednesday of the 21st Week
        // $first_semester_end = Carbon::createFromDate($first_semester_start)->addWeeks(21)->startOfWeek()->addDays(2);
        // // Second Semester starts after a 2-week break on Monday
        // $second_semester_start = Carbon::createFromDate($first_semester_end)->addWeeks(2)->startOfWeek();
        // // Second Semester ends on Wednesday of the 18th Week
        // $second_semester_end = Carbon::createFromDate($second_semester_start)->addWeeks(18)->startOfWeek()->addDays(2);
        // // Summer Term starts after 2 week-break on Monday
        // $summer_term_start = Carbon::createFromDate($second_semester_end)->addWeeks(2)->startOfWeek();
        // // Summer Term ends after 1 Month and 1 week on a Friday
        // $summer_term_end = Carbon::createFromDate($summer_term_start)->addMonth()->addWeeks(1)->startOfWeek()->addDays(4);
        // $annual_start = $first_semester_start;
        // $annual_end = $summer_term_end;
        

    }
}
