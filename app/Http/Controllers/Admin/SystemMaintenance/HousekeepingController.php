<?php

namespace App\Http\Controllers\Admin\SystemMaintenance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ArBackup;
use App\Models\AccomplishmentReport;
use App\Models\SchoolYear;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\EventDocument;
use App\Models\StudentAccomplishment;
use App\Models\StudentAccomplishmentFile;
use App\Models\OrganizationDocument;
use App\Models\Organization;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Madnest\Madzipper\Madzipper;

use App\Services\NotificationServices\Admin\AdminNotificationService;
use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;
use App\Http\Controllers\Controller as Controller;

class HousekeepingController extends Controller
{
    protected $viewDirectory = 'admin.maintenances.system.housekeeping.';
    protected $permissionChecker;
    protected $dataLogger;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
        $this->dataLogger = new DataLogService();
    }

    /**
     * Function to show Index Page of all SOIS-AR Backups
     * @return void
     */
    public function index()
    {
        abort_if(!$this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Organization'), 403);

        $arBackups = ArBackup::all();
        $schoolYears = SchoolYear::orderBy('annual_start', 'ASC')->get();
        return view(
            $this->viewDirectory . 'index',
            compact(
                'arBackups',
                'schoolYears',
            )
        );
    }

    /**
     * @param Request $request
     * Function to create a SOIS-AR Backup and Delete all Events, StudentAccomplishments, Accomplishment Reports, 
     * and Organization Documents in a School Year
     * @return void
     */
    public function create(Request $request)
    {
        abort_if(!$this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Organization'), 403);

        // Get School Year 
        $schoolYear = SchoolYear::where('school_year_id', $request->school_year)->first();

        // Get AR and Organization Documents in that school year 
        $accomplishmentReports = AccomplishmentReport::whereBetween('start_date', [$schoolYear->annual_start, $schoolYear->annual_end])
            ->get();

        $organizationDocuments = OrganizationDocument::with('documentType')
            ->whereBetween('effective_date', [$schoolYear->annual_start, $schoolYear->annual_end])
            ->get();
        
        // Check if AR and OrgDocu is empty
        if ($accomplishmentReports->isEmpty() && $organizationDocuments->isEmpty())
        {
            return redirect()->action(
                [HousekeepingController::class, 'index'])
                    ->with(array('error' => 'No Accomplishment Report or Organization Documents found.'));
        }

        // Get All Organization IDs that generated AR and uploaded OrgDocuments
        $organizationIDs = array();
        $organizationIDs += $accomplishmentReports->pluck('organization_id')->toArray();
        $organizationIDs += $organizationDocuments->pluck('documentType.organization_id')->toArray();
        $organizationIDs = collect($organizationIDs)->unique()->toArray();

        $organizations = Organization::whereIn('organization_id', $organizationIDs)->get();

        // Setup Folder Names and Temporary Backup Paths
        $backupFolderName = 
            'SOIS-AR-ARCHIVE-' . 
            date_format(date_create($schoolYear->annual_start), 'Y') . '-' . 
            date_format(date_create($schoolYear->annual_end), 'Y');
        $backupTempPath = '/public/backup/tmp';
        $dbBackupPath = '/backup/' . $backupFolderName . '.zip';

        // Loop through all organizations to sort files by Org Acronym
        foreach ($organizations as $organization) {
            // Filter AR and OrgDocu by organization ID
            $organizationAR = $accomplishmentReports->where('organization_id', $organization->organization_id);
            $organizationDocs = $organizationDocuments->where('documentType.organization_id', $organization->organization_id);

            // Move Files to temporary storage to zip later
            foreach ($organizationAR as $accomplishmentReport) {
                // If file is missing, continue process
                try {
                    Storage::move(
                        '/public' . $accomplishmentReport->file,
                        $backupTempPath . '/' . $backupFolderName . '/' . $organization->organization_acronym . '/' . $accomplishmentReport->title . '-' . uniqid() . '.' . pathinfo($accomplishmentReport->file, PATHINFO_EXTENSION)
                    );
                } catch (\League\Flysystem\FileNotFoundException $e) {
                    continue;
                }
            }
            foreach ($organizationDocs as $document) {
                try {
                    Storage::move(
                        '/public' . $document->file,
                        $backupTempPath . '/' . $backupFolderName . '/' . $organization->organization_acronym . '/' . $document->documentType->type . '-' . uniqid() . '.' . pathinfo($document->file, PATHINFO_EXTENSION)
                    );
                } catch (\League\Flysystem\FileNotFoundException $e) {
                    continue;
                }
            }
        }
        
        // Zip all files
        $this->zipFiles($backupTempPath, $backupFolderName);

        // Cleanup Temporary Directory
        $this->deleteDirectory($backupTempPath . '/' . $backupFolderName);

        // Save Backup Record to DB
        ArBackup::create([
            'location' => $dbBackupPath,
            'start_year' => (int)date_format(date_create($schoolYear->annual_start), 'Y'),
            'end_year' => (int)date_format(date_create($schoolYear->annual_end), 'Y'),
        ]);

        $this->dataLogger->log(Auth::user()->user_id, 'User Created a SOIS-AR Backup');
        
        // After Backup is saved, start deleting Events, Student Accomplishments, AR, and OrgDocu
        $this->deleteEvents($schoolYear);
        $this->deleteStudentAccomplishments($schoolYear);
        $this->deleteAccomplishmentReports($schoolYear, $accomplishmentReports);
        $this->deleteOrganizationDocuments($schoolYear, $organizationDocuments);

        // Send Notification to all Officers/Presidents of the System
        $notification = (new AdminNotificationService())->sendNotificationForYearlyHousekeeping($schoolYear);
        
        return redirect()->action(
            [HousekeepingController::class, 'index'])
                ->with(array('success' => 'Successful Backup!'));
    }

    /**
     * @param Collection $schoolYear
     * Private Function to Delete Events and the associated Images and Documents within a School Year
     * @return void
     */
    private function deleteEvents($schoolYear)
    {
        // Get Event IDs and the Images and Documents associated with them
        $eventIDs = Event::whereBetween('start_date', [$schoolYear->annual_start, $schoolYear->annual_end])
            ->withTrashed()->pluck('accomplished_event_id');
        
        // Skip if there are no Events
        if (count($eventIDs) == 0) 
            return;
        
        $eventImages = EventImage::whereIn('accomplished_event_id', $eventIDs)
            ->withTrashed()->select('event_image_id', 'image')->get();
        $eventDocuments = EventDocument::whereIn('accomplished_event_id', $eventIDs)
            ->withTrashed()->select('event_document_id', 'file')->get();
        
        // Collect each Image and Document from Storage to delete
        $filesToDelete = array();
        
        foreach($eventImages as $image)
        {
            array_push($filesToDelete, $image->image);
        }
        foreach($eventDocuments as $document)
        {
            array_push($filesToDelete, $document->file);
        }

        // Bulk Delete in Storage
        $this->deleteFiles($filesToDelete);

        // Delete Event Images in Database
        EventImage::destroy($eventImages->pluck('event_image_id')->all());
        EventImage::whereIn('event_image_id', $eventImages->pluck('event_image_id'))
            ->onlyTrashed()->forceDelete();
        
        // Delete Event Documents in Database
        EventDocument::destroy($eventDocuments->pluck('event_document_id')->all());
        EventDocument::whereIn('event_document_id', $eventDocuments->pluck('event_document_id'))
            ->onlyTrashed()->forceDelete();

        // Delete Events in Database
        Event::destroy($eventIDs);
        Event::whereIn('accomplished_event_id', $eventIDs)
            ->withTrashed()->forceDelete();

        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted Events for SY ' . 
            date_format(date_create($schoolYear->annual_start), 'Y') . '-' .
            date_format(date_create($schoolYear->annual_end), 'Y')); 
    }

    /**
     * @param Collection $schoolYear
     * Private Function to Delete Student Accomplishments and the associated Files within a School Year
     * @return void
     */
    private function deleteStudentAccomplishments($schoolYear)
    {
        // Get SA IDs and the files associated with them
        $studentAccomplishmentIDs = StudentAccomplishment::whereBetween('start_date', [$schoolYear->annual_start, $schoolYear->annual_end])
            ->pluck('student_accomplishment_id')->all();
        $studentAccomplishmentFiles = StudentAccomplishmentFile::whereIn('student_accomplishment_id', $studentAccomplishmentIDs)->select('student_accomplishment_file_id', 'file')->get();
        
        // Skip if there are no Student Accomplishments
        if (count($studentAccomplishmentIDs) == 0) 
            return;

        // Collect each File from Storage to delete
        $filesToDelete = array();
        foreach($studentAccomplishmentFiles as $file)
        {
            array_push($filesToDelete, $file->file);
        }

        // Bulk Delete in Storage
        $this->deleteFiles($filesToDelete);

        // Delete Student Accomplishment Files first
        StudentAccomplishmentFile::destroy($studentAccomplishmentFiles->pluck('student_accomplishment_file_id')->all());
        StudentAccomplishmentFile::whereIn('student_accomplishment_file_id', $studentAccomplishmentFiles->pluck('student_accomplishment_file_id')->all())
            ->withTrashed()->forceDelete();
        
        // Delete Student Accomplishments in Database
        StudentAccomplishment::destroy($studentAccomplishmentIDs);
        StudentAccomplishmentFile::whereIn('student_accomplishment_file_id', $studentAccomplishmentIDs)
            ->withTrashed()->forceDelete();

        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted Student Accomplishments for SY ' .
            date_format(date_create($schoolYear->annual_start), 'Y') . '-' . 
            date_format(date_create($schoolYear->annual_end), 'Y'));
    }

    /**
     * @param Collection $schoolYear, Collection $accomplishmentReports
     * Private Function to Delete Accomplishment Reports within a School Year
     * @return void
     */
    private function deleteAccomplishmentReports($schoolYear, $accomplishmentReports)
    {
        // Get AR IDs
        $accomplishmentReportIDs = $accomplishmentReports->pluck('accomplishment_report_id')->all();

        // Skip if there are no Accomplishment Reports
        if (count($accomplishmentReportIDs) == 0) 
            return;

        // Collect each File from Storage to delete
        $filesToDelete = array();
        foreach($accomplishmentReports as $accomplishmentReport)
        {
            array_push($filesToDelete, $accomplishmentReport->file);
        }

        // Bulk Delete in Storage
        $this->deleteDirectories($filesToDelete);

        // Delete Accomplishment Reports in Database
        AccomplishmentReport::destroy($accomplishmentReportIDs);
        AccomplishmentReport::whereIn('accomplishment_report_id', $accomplishmentReportIDs)
            ->withTrashed()->forceDelete();

        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted Accomplishment Reports for SY ' .
            date_format(date_create($schoolYear->annual_start), 'Y') . '-' . 
            date_format(date_create($schoolYear->annual_end), 'Y'));
    }

    /**
     * @param Collection $schoolYear, Collection $organizationDocuments
     * Private Function to Delete Organization Documents within a School Year
     * @return void
     */
    private function deleteOrganizationDocuments($schoolYear, $organizationDocuments)
    {
        // Get AR IDs
        $organizationDocumentIDs = $organizationDocuments->pluck('organization_document_id')->all();

        // Skip if there are no Organization Documents
        if (count($organizationDocumentIDs) == 0) 
            return;

        // Collect each File from Storage to delete
        $filesToDelete = array();
        foreach($organizationDocuments as $organizationDocument)
        {
            array_push($filesToDelete, $organizationDocument->file);
        }

        // Bulk Delete in Storage
        $this->deleteFiles($filesToDelete);

        // Delete Organization Documents in Database
        OrganizationDocument::destroy($organizationDocumentIDs);
        OrganizationDocument::whereIn('organization_document_id', $organizationDocumentIDs)
            ->withTrashed()->forceDelete();
        
        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted Organization Documents for SY ' .
            date_format(date_create($schoolYear->annual_start), 'Y') . '-' . 
            date_format(date_create($schoolYear->annual_end), 'Y'));
    }

    /**
     * @param Int $arBackupID
     * Function to Download a zipped SOIS-AR Backup
     * @return Response
     */
    public function download($arBackupID)
    {
        abort_if(!$this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Organization'), 403);

        $arBackup = ArBackup::where('ar_backup_id', $arBackupID)->firstOrFail();
        $filePath = storage_path('/app/public'. $arBackup->location);
        $headers = [
            'Content-Type: application/zip', 
            'Content-Disposition: attachment; filename="' . basename($filePath) . '"',
            'Content-Length: ' . filesize($filePath),
        ];
        $this->dataLogger->log(Auth::user()->user_id, 'User Downloaded SOIS-AR Backup.');
        return response()->download($filePath, basename($filePath), $headers);
    }

     /**
     * @param String $folderPath
     * Private Function to delete a directory.
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.1);
        Storage::deleteDirectory($folderPath);
    }

     /**
     * @param Array $folderPath
     * Private Function to delete directories.
     * Exclusive for AR Directory from a given DB path only
     * @return void
     */
    private function deleteDirectories($folderPaths)
    {
        foreach ($folderPaths as $path)
        {
            // Checks if directory exists, then checks if the file exists in that directory
            $pathDirectoryOnly = pathinfo($path, PATHINFO_DIRNAME);
            if (file_exists(storage_path('app/public/' . $pathDirectoryOnly )))
            {
                if (file_exists(storage_path('app/public/' . $path )))
                    unlink(storage_path('app/public/' . $path));
                rmdir(storage_path('app/public/' . $pathDirectoryOnly ));
            }
        }
        
    }

    /**
     * @param Array $files
     * Private Function to delete files.
     * @return void
     */
    private function deleteFiles($files)
    {
        foreach($files as $file)
        {
            // Check if the file exists to prevent error
            if (file_exists(storage_path('app/public/' . $file)))
                unlink(storage_path('app/public/' . $file));
            else
                continue;
        }
    }

    /**
     * @param String $folderPath, String $folderName
     * Private Function to Zip Files
     * @return void
     */
    private function zipFiles($folderPath, $folderName)
    {
        $zipper = new Madzipper;
        $files = glob(storage_path('app' . $folderPath . '/' . $folderName));
        $zipper->make(storage_path('app/public/backup/' . $folderName . '.zip'))->add($files);
        $zipper->close();
    }
}
