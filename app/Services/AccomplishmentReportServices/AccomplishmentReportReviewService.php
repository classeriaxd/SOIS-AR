<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use App\Models\PositionTitle;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;

use App\Services\NotificationServices\{
    AccomplishmentReportNotificationService,
};

class AccomplishmentReportReviewService
{
    /**
     * @param  Collection $accomplishmentReport, Request $request     
     * Service that Approves/Declines an Accomplishment Report.
     * @return String
     */
    public function reviewAccomplishmentReport(AccomplishmentReport $accomplishmentReport, $request)
    {
        if ($request->has('success')) 
            $message = $this->approveAccomplishmentReport_Design($accomplishmentReport, $request);
        else if ($request->has('decline'))
            $message = $this->declineAccomplishmentReport_Design($accomplishmentReport, $request);

        return $message;
    }

    /**
     * @param Collection $accomplishmentReport
     * Function for automated approval of Accomplishment Reports that are of type Tabular
     * @return String
     */
    public function approveAccomplishmentReport_Tabular(AccomplishmentReport $accomplishmentReport)
    {
        $accomplishmentReport->update([
                'status' => 2,
                'reviewed_by' => Auth::user()->user_id,
                'remarks' => 'Approved automatically by the System',
        ]);
    }

    /**
     * @param Collection $accomplishmentReport, Request $request
     * Function to approve Accomplishment Reports that are of type Design
     * @return String
     */
    private function approveAccomplishmentReport_Design(AccomplishmentReport $accomplishmentReport, $request)
    {
        $signatoryDocumentationOfficers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
        $signatoryPresident = ['President'];

        $signature = false;

        if($request->has('esignature'))
            $signature = true;

        $rangeTitle = $accomplishmentReport->range_title;
        $startDate = Carbon::parse($accomplishmentReport->start_date)->format('F d, Y');
        $endDate = Carbon::parse($accomplishmentReport->end_date)->format('F d, Y');

        $documentationSignatory = PositionTitle::with(['users' => function($query) {
            $query->select([DB::raw('CONCAT(first_name, " ", middle_name, " ", last_name) as full_name')]);
        }])
            ->whereIn('position_title', $signatoryDocumentationOfficers)
            ->where('organization_id', $accomplishmentReport->organization_id)
            ->orderBy('position_title', 'DESC')
            ->get();

        $presidentSignatory = PositionTitle::with(['users' => function($query) {
            $query->select([DB::raw('CONCAT(first_name, " ", middle_name, " ", last_name) as full_name')]);
        }])
            ->whereIn('position_title', $signatoryPresident)
            ->where('organization_id', $accomplishmentReport->organization_id)
            ->first();

        $organization = Organization::with('assets')
            ->where('organization_id', $accomplishmentReport->organization_id)
            ->first();
        
        // Create temporary folder directory
        $temporaryFolder = 'tmp/temporaryFolder-' . uniqid() . '-' . now()->timestamp;
        if (!is_dir(storage_path('/app/public/compiledDocuments/tmp/'))) {
            // dir doesn't exist, make it
            mkdir(storage_path('/app/public/compiledDocuments/tmp/'));
        }
        if (!is_dir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder))) {
            // dir doesn't exist, make it
            mkdir(storage_path('/app/public/compiledDocuments/' . $temporaryFolder));
        }

        // Create Array and insert accomplishment report first
        $compiledDocuments = array(storage_path('/app/public/' . $accomplishmentReport->file));

        // Create Signatory Page PDF then insert to Array
        $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
        $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.signatoryPage', compact('documentationSignatory', 'presidentSignatory', 'organization', 'signature'))
            ->setPaper('letter', 'portrait')
            ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
        array_unshift($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));

        // Create Title Page PDF then insert to Array
        $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
        $dompdf = PDF::loadView('accomplishmentreports.pdfTemplates.titlePage', compact('organization', 'rangeTitle', 'startDate', 'endDate'))
            ->setPaper('letter', 'portrait')
            ->save(storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));
        array_unshift($compiledDocuments, storage_path('/app/public/compiledDocuments/' . $temporaryFolder . '/' . $fileName));


        // Merge all documents then delete temporary folder
        $finalFolderName = uniqid() . '-' . now()->timestamp;
        if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'))) {
            // dir doesn't exist, make it
            mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/'));
        }
        if (!is_dir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName))) {
            // dir doesn't exist, make it
            mkdir(storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $finalFolderName));
        }

        $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
        $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
        $accomplishmentReport->update([
            'file' => '/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName,
            'status' => 2,
            'reviewed_by' => Auth::user()->user_id,
            'remarks' => $request->input('remarks'),
        ]);
        
        // Delete temporary directories
        $this->deleteDirectory($temporaryFolder);
        $this->deleteDirectory(Str::of(storage_path('/app/public/' . $accomplishmentReport->file))->dirname());

        // Send Notification to Officer
        $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
        $accomplishmentReportNotificationService->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'approved');

        $message = "Accomplishment Report has been approved! Notification sent to Documentation Officers.";

        return $message;
    }

    /**
     * @param Collection $accomplishmentReport, Request $request
     * Function to decline Accomplishment Reports that are of type Design
     * @return String
     */
    private function declineAccomplishmentReport_Design(AccomplishmentReport $accomplishmentReport, $request)
    {
        // Update Accomplishment Report
        $accomplishmentReport->update([
                'status' => 3,
                'reviewed_by' => Auth::user()->user_id,
                'remarks' => $request->input('remarks'),
            ]);

        // Send Notification to Officer
        $accomplishmentReportNotificationService = new AccomplishmentReportNotificationService();
        $accomplishmentReportNotificationService->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'declined');

        $message = "Accomplishment Report has been declined. Notification sent to Documentation Officers.";

        return $message;
    }

    /**
     * @param Array documents, String $fileName, $folderName
     * Function to Merge PDF using documents array.
     * @return void
     */
    private function mergePDF($documents, $fileName, $folderName)
    {
        $merger = new Merger;
        $merger->addIterator($documents);
        $mergedPDF = $merger->merge();
        $filePath = storage_path('/app/public/compiledDocuments/accomplishmentReports/' . $folderName . '/' . $fileName);
        file_put_contents($filePath, $mergedPDF);
    }

    /**
     * @param String $folder
     * Function to Delete Created Folder and its contents
     * @return void
     */
    private function deleteDirectory($folder)
    {
        // first delete contents of the directory, but preserve the directory itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder, true);
        // sleep 0.3 second because of race condition with HD
        sleep(0.3);
        // actually delete the folder itself
        Storage::deleteDirectory('/public/compiledDocuments/' . $folder);
    }
}
