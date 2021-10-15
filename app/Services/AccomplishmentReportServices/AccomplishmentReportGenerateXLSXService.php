<?php

namespace App\Services\AccomplishmentReportServices;

use App\Exports\AccomplishmentReportExport;
use Maatwebsite\Excel\Facades\Excel;

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
         * 4-- All Academic and Non Academic Events
         */ 
        $table1 = $studentAccomplishments->whereIn('level_id', [2,3,4,5]);
        $table1 = $table1->map->only(['title', 'organizer', 'venue', 'end_date', 'level']);

        $table2 = $events->where('event_category_id', 6);
        $table2 = $table2->map->only(['title', 'venue', 'end_date', 'eventLevel', 'total_beneficiary']);

        $table3 = $events->where('event_category_id', 5);
        $table3 = $table3->map->only(['organization', 'title', 'budget', 'eventFundSource', 'eventLevel', 'venue', 'start_date', 'end_date', 'start_time', 'end_time']);

        $table4 = $events->whereIn('event_category_id', [1,2]);

        $finalFolderName = uniqid() . '-' . now()->timestamp;
        $finalFileName = uniqid() . '-' . now()->timestamp . '.xlsx';
        $altFinalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
        
        Excel::store(new AccomplishmentReportExport($table1, $table2, $table3, $table4), '/public/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName);

        // Excel::store(new AccomplishmentReportExport($table1, $table2, $table3, $table4), '/public/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $altFinalFileName, '', \Maatwebsite\Excel\Excel::DOMPDF);
        

        $ARDirectory = [
            'finalFolderName' => $finalFolderName, 
            'finalFileName' => $finalFileName,
            // 'altFinalFileName' => $altFinalFileName,
        ];

        return $ARDirectory;
    }
}
