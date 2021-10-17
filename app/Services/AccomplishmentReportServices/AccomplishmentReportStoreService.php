<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AccomplishmentReportStoreService
{
    /**
     * @param Request $request, Array $ARDirectory, Collection $organization, Integer $reportType, Array $alternateDirectory
     * Service to Store an Accomplishment Report.
     * @return String
     */
    public function store($request, $ARDirectory, $organization, $reportType)
    {
        $rangeTitleRequest = $request->only('range_title');
        $rangeTitle = NULL;

        // Get range title
        switch ($rangeTitleRequest['range_title']) {
            case 'Semestral':
                $rangeTitle = 1;
                break;
            case 'Quarterly':
                $rangeTitle = 2;
                break;
            case 'Custom':
                $rangeTitle = 3;
                break;
        }

        // Pre-generate UUID for Accomplishment Report
        $accomplishmentReportUUID = Str::uuid();

        // Create new Accomplishment Report model
        $accomplishmentReportID = AccomplishmentReport::insertGetId([
            'accomplishment_report_uuid' => $accomplishmentReportUUID,
            'organization_id' => $organization->organization_id,
            'created_by' => Auth::user()->user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description', NULL),
            'file' => '/compiledDocuments/accomplishmentReports/' . $ARDirectory['finalFolderName'] . '/' . $ARDirectory['finalFileName'],
            
            // Accomplishment Report Type - 1 = Tabular | 2 = Design
            'accomplishment_report_type' => $reportType,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'range_title' => $rangeTitle,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return $accomplishmentReportUUID;
    }
}
