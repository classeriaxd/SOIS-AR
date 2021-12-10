<?php

namespace App\Services\AccomplishmentReportServices;

use App\Models\AccomplishmentReport;
use App\Models\Officer;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use iio\libmergepdf\Merger;
use PDF;

use App\Services\NotificationServices\{
    AccomplishmentReportNotificationService,
};

use Illuminate\Database\Eloquent\Builder;

class AccomplishmentReportReviewService
{
    protected $templateDirectory = 'accomplishmentReports.pdfTemplates.';
    protected $compiledDocumentDirectory = '/app/public/compiledDocuments/';
    protected $finalCompiledDocumentDirectory = '/app/public/compiledDocuments/accomplishmentReports/';
    /**
     * @param  String $accomplishmentReportUUID, Request $request     
     * Service that Approves/Declines an Accomplishment Report.
     * @return String
     */
    public function reviewAccomplishmentReport($accomplishmentReportUUID, $request):array
    {
        $accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first();

        if ($request->has('success')) 
            $returnArray = $this->approveAccomplishmentReport_Design($accomplishmentReport, $request);
        else if ($request->has('decline'))
            $returnArray = $this->declineAccomplishmentReport_Design($accomplishmentReport, $request);

        return $returnArray;
    }

    /**
     * @param Collection $accomplishmentReport
     * Function for automated approval of Accomplishment Reports that are of type Tabular
     * @return String
     */
    public function approveAccomplishmentReport_Tabular($accomplishmentReportUUID)
    {
        abort_if(! AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->exists(), 404);

        $accomplishmentReport = AccomplishmentReport::where('accomplishment_report_uuid', $accomplishmentReportUUID)->first();

        (new AccomplishmentReportNotificationService)->sendNotificationToSuperAdmin($accomplishmentReportUUID, 'Tabular', $accomplishmentReport->organization_id);

        $accomplishmentReport->update([
                'status' => 2,
                'reviewed_by' => Auth::user()->user_id,
                'remarks' => 'Approved automatically by the System',
        ]);
    }

    /**
     * @param Collection $accomplishmentReport, Request $request
     * Function to approve Accomplishment Reports that are of type Design
     * @return Array
     */
    private function approveAccomplishmentReport_Design(AccomplishmentReport $accomplishmentReport, $request): array
    {
        try 
        {
            $signature = false;
            if($request->has('esignature'))
                $signature = true;

            $rangeTitle = $accomplishmentReport->range_title;
            $startDate = Carbon::parse($accomplishmentReport->start_date)->format('F d, Y');
            $endDate = Carbon::parse($accomplishmentReport->end_date)->format('F d, Y');

            $organizationID = $accomplishmentReport->organization_id;

            // Overlap Dates
            // https://stackoverflow.com/questions/325933/determine-whether-two-date-ranges-overlap
            $documentationSignatory = Officer::whereHas(
                    'positionTitle', function(Builder $query) use($organizationID) {
                        $query->where('organization_id', $organizationID)->orderBy('position_title_id', 'ASC');},)
                ->whereHas(
                    'positionTitle.positionCategory', function(Builder $query) {
                        $query->where('position_category', 'Documentation');},)
                ->with('positionTitle:position_title_id,position_title')
                ->where('term_start', '<=', $accomplishmentReport->end_date)
                ->where('term_end', '>=', $accomplishmentReport->start_date)
                ->get();
            $presidentSignatory = Officer::whereHas(
                    'positionTitle', function(Builder $query) use($organizationID) {
                        $query->where('organization_id', $organizationID);},)
                ->whereHas(
                    'positionTitle.positionCategory', function(Builder $query) {
                        $query->where('position_category', 'President');},)
                ->with('positionTitle:position_title_id,position_title')
                ->where('term_start', '<=', $accomplishmentReport->end_date)
                ->where('term_end', '>=', $accomplishmentReport->start_date)
                ->first();
            // Get Organization Details including a single Logo
            $organization = Organization::with('logo')
                ->where('organization_id', $organizationID)
                ->first();
                
            // Create temporary folders and other directories
                $temporaryFolder = 'tmp/temporaryFolder-' . uniqid() . '-' . now()->timestamp;
                $finalFolderName = uniqid() . '-' . now()->timestamp;
                $finalFileName = uniqid() . '-' . now()->timestamp . '.pdf';
                // If directory doesnt exist, make it
                if (! is_dir(storage_path($this->compiledDocumentDirectory)))
                    mkdir(storage_path($this->compiledDocumentDirectory));
                if (! is_dir(storage_path($this->compiledDocumentDirectory . 'tmp')))
                    mkdir(storage_path($this->compiledDocumentDirectory . 'tmp'));
                if (! is_dir(storage_path($this->compiledDocumentDirectory . $temporaryFolder)))
                    mkdir(storage_path($this->compiledDocumentDirectory . $temporaryFolder));
                if (! is_dir(storage_path($this->finalCompiledDocumentDirectory)))
                    mkdir(storage_path($this->finalCompiledDocumentDirectory));
                if (! is_dir(storage_path($this->finalCompiledDocumentDirectory . $finalFolderName)))
                    mkdir(storage_path($this->finalCompiledDocumentDirectory . $finalFolderName));

            // Create Array and insert accomplishment report first
            $compiledDocuments = array(storage_path('/app/public/' . $accomplishmentReport->file));

            // Create Signatory Page PDF then append to first of Array
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView($this->templateDirectory . 'signatoryPage', compact('documentationSignatory', 'presidentSignatory', 'organization', 'signature'))
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path($this->compiledDocumentDirectory . $temporaryFolder . '/' . $fileName));
                array_unshift($compiledDocuments, storage_path($this->compiledDocumentDirectory . $temporaryFolder . '/' . $fileName));

            // Create Title Page PDF then insert to Array
                $fileName = 'temporary-' . uniqid() . '-' . now()->timestamp . '.pdf';
                $dompdf = PDF::loadView($this->templateDirectory . 'titlePage', compact('organization', 'rangeTitle', 'startDate', 'endDate'))
                    ->setPaper('letter', 'portrait')
                    ->save(storage_path($this->compiledDocumentDirectory . $temporaryFolder . '/' . $fileName));
                array_unshift($compiledDocuments, storage_path($this->compiledDocumentDirectory . $temporaryFolder . '/' . $fileName));

            

            // Merge all documents then delete temporary folder
            $this->mergePDF($compiledDocuments, $finalFileName, $finalFolderName);
            $accomplishmentReport->update([
                'file' => '/compiledDocuments/accomplishmentReports/' . $finalFolderName . '/' . $finalFileName,
                'status' => 2,
                'reviewed_by' => Auth::user()->user_id,
                'reviewed_at' => Carbon::now(),
                'remarks' => $request->input('remarks'),
            ]);

            // Delete temporary directories
            $this->deleteDirectory($temporaryFolder);
            $this->deleteDirectory(Str::of(storage_path('/app/public/' . $accomplishmentReport->file))->dirname());

            // Send Notification to Officer
            // This method chains to notify the Super Admin
            (new AccomplishmentReportNotificationService())->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'approved');

            $returnArray = array( 
                'message' => array('success' => 'Accomplishment Report has been approved! Notification sent to Documentation Officers.'),
            );

            return $returnArray;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'message' => array('error' => 'Error in approving Accomplishment Report' . $e->getMessage()),
            );

            return $returnArray;
        }
    }

    /**
     * @param Collection $accomplishmentReport, Request $request
     * Function to decline Accomplishment Reports that are of type Design
     * @return Array
     */
    private function declineAccomplishmentReport_Design(AccomplishmentReport $accomplishmentReport, $request): array
    {
        try 
        {
            // Update Accomplishment Report
            $accomplishmentReport->update([
                    'status' => 3,
                    'reviewed_by' => Auth::user()->user_id,
                    'remarks' => $request->input('remarks'),
                    'reviewed_at' => Carbon::now(),
                ]);

            // Send Notification to Officer
            (new AccomplishmentReportNotificationService())->sendNotificationToOfficer($accomplishmentReport->organization_id, $accomplishmentReport->accomplishment_report_uuid, 'declined');

            $returnArray = array(
                'reviewed' => true, 
                'message' => array('success' => 'Accomplishment Report has been declined. Notification sent to Documentation Officers.'),
            );
            return $returnArray;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'reviewed' => false, 
                'message' => array('error' => 'Error in declining Accomplishment Report' . $e->getMessage()),
            );

            return $returnArray;
        }
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
        $filePath = storage_path($this->finalCompiledDocumentDirectory . $folderName . '/' . $fileName);
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
