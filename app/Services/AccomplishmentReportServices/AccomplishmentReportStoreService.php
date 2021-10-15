<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AccomplishmentReportStoreService
{
    /**
     * @param Request $request, Array $ARDirectory, Collection $organization, Integer $reportType, Array $alternateDirectory
     * 
     * Service to Store an Accomplishment Report.
     * Returns Accomplishment UUID on success.
     *
     * @return String
     */
    public function store($request, $ARDirectory, $organization, $reportType)
    {
        $rangeTitleRequest = $request->only('range_title');
        $rangeTitle = NULL;

        // change range title
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

        $accomplishmentReportUUID = Str::uuid();
        // Create new CompiledDocument model
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
        ]);

        return $accomplishmentReportUUID;
    }
}
