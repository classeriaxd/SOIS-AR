<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Services\NotificationServices\{
    AccomplishmentReportNotificationService,
};

use App\Services\AccomplishmentReportServices\{
    AccomplishmentReportReviewService,
};

class AccomplishmentReportStoreService
{
    /**
     * @param Request $request, Array $ARDirectory, String $organizationID
     * Service to Store an Accomplishment Report.
     * Returns UUID and Message on Success/Fail
     * @return Array
     */
    public function store($request, $ARDirectory, $organizationID): array
    {
        try 
        {
            // Get range title
            switch ($request->input('range_title')) 
            {
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
            $accomplishmentReport = AccomplishmentReport::create([
                'accomplishment_report_uuid' => $accomplishmentReportUUID,
                'organization_id' => $organizationID,
                // Accomplishment Report Type - 1 = Tabular | 2 = Design
                'accomplishment_report_type_id' => $request->input('ar_format'),
                'created_by' => Auth::user()->user_id,
                'title' => $request->input('title'),
                'description' => $request->input('description', NULL),
                'file' => '/compiledDocuments/accomplishmentReports/' . $ARDirectory['finalFolderName'] . '/' . $ARDirectory['finalFileName'],
                
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'range_title' => $rangeTitle,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Send Notification to Organization President
            (new AccomplishmentReportNotificationService())->sendNotificationToPresident(Auth::user()->full_name, $organizationID, $accomplishmentReportUUID);

            // Set Success message depending on AR Format
            if ($request->input('ar_format') == 1)
            {
                $successMessage = 'Accomplishment Report Generated and Approved. No approval process is required for Tabular Reports.';
                // Automatic approval for Tabular reports
                (new AccomplishmentReportReviewService())->approveAccomplishmentReport_Tabular($accomplishmentReportUUID);
            } 
            elseif ($request->input('ar_format') == 2)
                $successMessage = 'Accomplishment Report Generated. Sent in for President\'s Approval.';
            
            $returnArray = array(
                'accomplishmentReportUUID' => $accomplishmentReportUUID,
                'message' => array('success' => $successMessage));

            return $returnArray;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'accomplishmentReportUUID' => NULL,
                'message' => array('error' => 'Error in Storing Accomplishment Report. ' . $e->getMessage()));

            return $returnArray;
        }
    }
}
