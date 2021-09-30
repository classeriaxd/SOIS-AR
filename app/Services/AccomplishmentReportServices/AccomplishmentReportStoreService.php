<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AccomplishmentReportStoreService
{
    /**
     * Service to Store an Accomplishment Report.
     * Returns Accomplishment UUID on success.
     *
     * @return String
     */
    public function store($request, $ARDirectory, $organization)
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
        // Create new CompiledDocument model
        $accomplishmentReportUUID = AccomplishmentReport::create([
            'accomplishment_report_uuid' => Str::uuid(),
            'organization_id' => $organization->organization_id,
            'created_by' => Auth::user()->user_id,
            'title' => $request->input('title'),
            'description' => $request->input('description', NULL),
            'file' => '/compiledDocuments/accomplishmentReports/' . $ARDirectory['finalFolderName'] . '/' . $ARDirectory['finalFileName'],
            'for_archive' => ($request->has('archive') ? 1 : 0),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'range_title' => $rangeTitle,
        ])->accomplishment_report_uuid;

        return $accomplishmentReportUUID;
    }
}
