<?php

namespace App\Services\AccomplishmentReportServices;

use App\Exports\AccomplishmentReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TabularTable;


class AccomplishmentReportGenerateXLSXService
{
    /**
     * @param Collection $events, Collection $studentAccomplishments
     * Service to generate Tabular XLSX Accomplishment Report.
     * Returns Array of Final File Name and Folder Name
     * @return array
     */
    public function generate($events, $studentAccomplishments)
    {

        /*** 4 tables
         * 1-- Student Accomplishments outside PUP
         * 2-- Events under Community Outreach category
         * 3-- Events that are Seminar/Workshops
         * 4-- All Other Academic and Non Academic Events
         */ 
        
        // Get all Stored Table Columns
        $tables = TabularTable::with('tabularColumns:tabular_column_id,tabular_table_id,tabular_column_name')
            ->get();

        // VII. Students Awards/Recognitions from  Reputable Organizations
        $table1 = $studentAccomplishments->whereIn('level_id', [2,3,4,5]);
        $table1 = $table1->map->only(['title', 'organizer', 'venue', 'end_date', 'level']);

        // VIII. Community Relation and Outreach Program
        $table2 = $events->where('event_category_id', 6);
        $table2 = $table2->map->only(['title', 'venue', 'end_date', 'eventLevel', 'total_beneficiary', 'eventDocuments']);
        
        // IX. STUDENTS TRAININGS AND SEMINARS
        $table3 = $events->where('event_category_id', 5);
        $table3 = $table3->map->only(['organization', 'title', 'budget', 'eventFundSource', 'eventNature', 'eventClassification', 'eventLevel', 'venue', 'start_date', 'end_date', 'start_time', 'end_time', 'eventDocuments']);

        // X. OTHER STUDENT ACTIVITIES
        $table4 = $events->whereIn('event_category_id', [1,2,3,4]);
        $table4 = $table4->map->only(['organization', 'title', 'budget', 'eventFundSource', 'eventNature', 'eventClassification', 'eventLevel', 'venue', 'start_date', 'end_date', 'start_time', 'end_time', 'eventDocuments']);
        
        $finalFolderName = uniqid() . '-' . now()->timestamp;
        $finalFileName = uniqid() . '-' . now()->timestamp . '.xlsx';
        
        Excel::store(new AccomplishmentReportExport($tables, $table1, $table2, $table3, $table4), '/public/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName);
        

        $ARDirectory = [
            'finalFolderName' => $finalFolderName, 
            'finalFileName' => $finalFileName,
        ];

        return $ARDirectory;
    }
}
