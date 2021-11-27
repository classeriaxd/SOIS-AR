<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventDocument;
use App\Models\EventDocumentType;
use App\Models\TemporaryFile;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\EventDocumentRequests\{
    EventDocumentStoreRequest,
};

use iio\libmergepdf\Merger;

use App\Services\PermissionServices\PermissionCheckingService;

class EventDocumentsController extends Controller
{
    protected $permissionChecker;
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
    }

    public function create($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $filePondJS = true;
        $eventDocumentTypes = EventDocumentType::all();
        $event = Event::where('slug', $event_slug)->first();
        return view('eventdocuments.create', compact('event','filePondJS', 'eventDocumentTypes'));
    }
    public function store(EventDocumentStoreRequest $request, $event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Create_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $tempPath = '/public/uploads/tmp/';
        $finalPath = '/public/uploads/events/documents/';
        $dbPath = '/uploads/events/documents/';

        if($request->has('document'))
        {
            $file = TemporaryFile::where('folder', $request->input('document'))->value('filename');
            Storage::move($tempPath . $request->input('document') . '/' . $file, $finalPath . $file);
            $this->deleteDirectory($tempPath . $request->input('document'));
            TemporaryFile::where('folder', $request->input('document'))->delete();

            EventDocument::create([
                'accomplished_event_id' => $event->accomplished_event_id,
                'event_document_type_id' => $request->input('document_type'),
                'title' => $request->input('title', NULL),
                'description' => $request->input('description', NULL),
                'file' =>  $dbPath . $file, 
            ]);
        }
        return redirect()->action(
            [EventsController::class, 'show'], ['event_slug' => $event->slug]
        );
       
    }
    public function index($event_slug)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-View_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $eventDocuments = DB::table('event_documents as documents')
            ->join('event_document_types as types','documents.event_document_type_id','=','types.event_document_type_id')
            ->where('documents.accomplished_event_id', $event->accomplished_event_id)
            ->whereNull('documents.deleted_at')
            ->orderBy('documents.event_document_type_id', 'ASC')
            ->select('types.document_type as document_type', 'documents.title as title', 'documents.file as file', 'documents.event_document_id as event_document_id')
            ->get();
        return view('eventdocuments.index', compact('event', 'eventDocuments'));

    }

    public function destroy($event_slug, $document_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Delete_Event_Document'), 403);
        abort_if(! Event::where('slug', $event_slug)->exists(), 404);
        abort_if(! EventDocument::where('event_document_id', $document_id)->exists(), 404);

        $event = Event::where('slug', $event_slug)->first();
        $document = EventDocument::where('event_document_id', $document_id)
            ->where('accomplished_event_id', $event->accomplished_event_id)
            ->first();
        $document->delete();
        
        return redirect()->action(
            [EventsController::class, 'show'], ['event_slug' => $event->slug]);
    }

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
            return response()->download($filePath, $fileName, $headers);
        }
        else
            return NULL;
    }

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
            $fileName = Str::limit(Str::slug($event->title, '-'), 20, '-') . '-docu-compiled-' . date('MdY') . '.pdf';
            $filePath = storage_path('/app/public/compiledDocuments/' . $fileName);
            file_put_contents($filePath, $mergedPDF);

            // Send Download Response
            $headers = ['Content-Type: application/pdf'];
            return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(true);
        }
        else
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug]);
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
    
    /**
     * @param String $folderPath
     * Private Function to delete temporary directories.
     * @return void
     */
    private function deleteDirectory($folderPath)
    {
        Storage::deleteDirectory($folderPath, true);
        sleep(0.3);
        Storage::deleteDirectory($folderPath);
    }
}
