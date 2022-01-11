<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDocument;
use App\Models\EventDocumentType;
use App\Models\TemporaryFile;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\EventDocumentRequests\{
    EventDocumentStoreRequest,
};

use App\Services\EventServices\EventDocumentServices\{
    EventDocumentStoreService,
    EventDocumentDeleteService,
    EventDocumentRestoreService,
};

use iio\libmergepdf\Merger;

use App\Services\PermissionServices\PermissionCheckingService;
use App\Services\DataLogServices\DataLogService;

class EventDocumentsController extends Controller
{
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
     * @param String $event_slug
     * Function to open Create Page for Event Document
     * @return View
     */
    public function create($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $eventDocumentTypes = EventDocumentType::all();
        $filePondJS = true;

        return view('eventdocuments.create', compact('event','filePondJS', 'eventDocumentTypes'));
    }

    /**
     * @param Request $request, String $event_slug
     * Function to store an Event Document
     * @return Redirect
     */
    public function store(EventDocumentStoreRequest $request, $event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $message = (new EventDocumentStoreService())->store($request, $event);

        $this->dataLogger->log(Auth::user()->user_id, 'User Created an Event Document.');

        return redirect()->action(
            [EventsController::class, 'show'], ['event_slug' => $event->slug])
            ->with($message);
       
    }

    /**
     * @param String $event_slug
     * Function to open Index Page for Event Document
     * @return View
     */
    public function index($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $eventDocuments = EventDocument::with('documentType:event_document_type_id,document_type')
            ->where('accomplished_event_id', $event->accomplished_event_id)
            ->orderBy('event_document_type_id', 'ASC')
            ->get();
        $deletedEventDocuments = EventDocument::onlyTrashed()
            ->where('accomplished_event_id', $event->accomplished_event_id)
            ->with('documentType:event_document_type_id,document_type')
            ->get();
        return view('eventdocuments.index', compact('event', 'eventDocuments', 'deletedEventDocuments'));

    }

    /**
     * @param String $event_slug, Integer $document_id
     * Function to soft delete an Event Document
     * @return Redirect
     */
    public function destroy($event_slug, $document_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventDocument::where('event_document_id', $document_id)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        
        $message = (new EventDocumentDeleteService())->destroy($event, $document_id);

        $this->dataLogger->log(Auth::user()->user_id, 'User Deleted an Event Document.');
        
        return redirect()->action(
            [EventDocumentsController::class, 'index'], ['event_slug' => $event->slug])
            ->with($message);
    }

    /**
     * @param String $event_slug, Integer $document_id
     * Function to restore soft deleted Event Document
     * @return Redirect
     */
    public function restore($event_slug, $document_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventDocument::withTrashed()->where('event_document_id', $document_id)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();

        $message = (new EventDocumentRestoreService())->restore($event, $document_id);

        $this->dataLogger->log(Auth::user()->user_id, 'User Restored an Event Document.');

        return redirect()->action(
            [EventDocumentsController::class, 'index'], ['event_slug' => $event->slug])
            ->with($message);
    }

    /**
     * @param String $event_slug, Integer $document_id
     * Function to download an Event Document
     * @return Download Response
     */
    public function downloadDocument($event_slug, $document_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Download_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventDocument::where('event_document_id', $document_id)->exists(), 404);

        $event = Event::with([
                'eventDocument' => function ($query) use ($document_id) {
                    $query->where('event_document_id', $document_id);},
                'eventDocument.documentType:event_document_type_id,document_type',
                ])
            ->where('slug', $event_slug)
            ->first();
        
        if ($event->eventDocument != NULL) 
        {
            $filePath = storage_path('/app/public/'. $event->eventDocument->file);
            $headers = ['Content-Type: application/pdf'];
            $fileName = Str::limit(Str::slug($event->eventDocument->title, '-'), 20, '-') .'-' . 
                Str::slug($event->eventDocument->documentType->type, '-') . 
                '.' . 
                pathinfo(storage_path($filePath), PATHINFO_EXTENSION);

            $this->dataLogger->log(Auth::user()->user_id, 'User Downloaded an Event Document.');

            return response()->download($filePath, $fileName, $headers);
        }
        else
            return NULL;
    }

    /**
     * @param String $event_slug
     * Function to compile and download event documents
     * @return Download Response | Redirect if there is no documents
     */
    public function downloadAllDocument($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Download_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::with('eventDocuments')->where('slug', $event_slug)->first();
        if ($event->eventDocuments->count() > 0)
        {
            $documentArray = array();
            foreach($event->eventDocuments as $document)
            {
                $filePath = storage_path('/app/public/'. $document->file);
                array_push($documentArray, $filePath);
            }
            $merger = new Merger;
            $merger->addIterator($documentArray);
            $mergedPDF = $merger->merge();
            $fileName = Str::limit(Str::slug($event->title, '-'), 20, '-') . '-compiled_on-' . date('MdY') . '.pdf';
            $filePath = storage_path('/app/public/compiledDocuments/' . $fileName);
            file_put_contents($filePath, $mergedPDF);

            // Send Download Response
            $headers = ['Content-Type: application/pdf'];

            $this->dataLogger->log(Auth::user()->user_id, 'User Downloaded Event Documents.');

            return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(true);
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug])
                ->with(array('error' => 'No Documents Found.'));
    }

    /**
     * @param Request $request
     * Function for FilePond JS File Upload 
     * https://pqina.nl/filepond/
     * @return text/plain JSON Response
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('document'))
        {
            $file = $request->validate([
                'document' => 'mimes:pdf'
            ]);
            $file = $request->file('document');
            $filename = uniqid() . '-' . now()->timestamp . '.' .$file->extension();
            $folder = uniqid() . '-' . now()->timestamp;
            $file->storeAs('/public/uploads/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);
            return $folder;
        }
        return 'not uploaded';
    }

    /**
     * @param Request $request
     * Function for FilePond JS Reverting File Upload 
     * https://pqina.nl/filepond/docs/api/server/#revert
     * @return empty JSON Response
     */
    public function undoUpload(Request $request)
    {
         if ($request->getContent())
         {
            $folder = $request->getContent();
            TemporaryFile::where('folder', $folder)->delete();
            // first delete contents of the directory, but preserve the directory itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder, true);
            // sleep 0.5 second because of race condition with HD
            sleep(0.5);
            // actually delete the folder itself
            Storage::deleteDirectory('/public/uploads/tmp/' . $folder);
            return 'file deleted';
         }
         return 'file not deleted';
    }
    
    
}
