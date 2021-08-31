<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\EventDocument;
use App\Models\EventDocumentType;
use App\Models\TemporaryFile;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use iio\libmergepdf\Merger;

class EventDocumentsController extends Controller
{
    public function create($event_slug)
    {
        $filePondJS = true;
        $eventDocumentTypes = EventDocumentType::all();
        $event = Event::where('slug', $event_slug)->first();
        return view('eventdocuments.create', compact('event','filePondJS', 'eventDocumentTypes'));
    }
    public function store($event_slug)
    {
        $document = request()->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'document_type' => 'required|exists:event_document_types,event_document_type_id',
            'document' => 'required|regex:/^[a-zA-Z0-9]{13}\-[0-9]{10}+$/',
        ]);
        if($event = Event::where('slug', $event_slug)->first())
        {
            $temp_path = '/public/uploads/tmp/';
            $final_path = '/public/uploads/event_documents/';
            $db_path = '/uploads/event_documents/';
            if($document['document'] ?? false)
            {
                $description = ($document['description'])?$document['description']:NULL;
                $file = TemporaryFile::where('folder', $document['document'])->value('filename');

                Storage::move($temp_path . $document['document'] . '/' . $file, $final_path . $file);
                Storage::deleteDirectory($temp_path . $document['document'], true);
                sleep(0.5);
                Storage::deleteDirectory($temp_path . $document['document']);
                EventDocument::create([
                    'event_id' => $event->event_id,
                    'event_document_type_id' => $document['document_type'],
                    'title' => $document['title'],
                    'description' => $description,
                    'file' =>  $db_path . $file, 
                ]);
            }
            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug]
            );
        }
        else
            abort(404);
    }
    public function index($event_slug)
    {
        if($event = Event::where('slug', $event_slug)->first())
        {
            $eventDocuments = DB::table('event_documents as documents')
            ->join('event_document_types as types','documents.event_document_type_id','=','types.event_document_type_id')
            ->where('documents.event_id', $event->event_id)
            ->whereNull('deleted_at')
            ->orderBy('documents.event_document_type_id', 'ASC')
            ->select('types.document_type as document_type', 'documents.title as title', 'documents.file as file', 'documents.event_document_id as event_document_id')
            ->get();
            return view('eventdocuments.index', compact('event', 'eventDocuments'));
        }
        else 
            abort(404);
    }
    public function destroy($event_slug, $document_id)
    {
        if($event = Event::where('slug', $event_slug)->first())
        {
            if($document = EventDocument::where('event_document_id', $document_id)
                ->where('event_id', $event->event_id)->first())
            {
                $document->delete();
            }
            else
                abort(404);

            return redirect()->action(
                [EventsController::class, 'show'], ['event_slug' => $event->slug]);
        }
        else
            abort(404);
    }
    public function downloadDocument($event_slug, $document_id)
    {
        if($document = DB::table('events')
            ->join('event_documents as documents', 'events.event_id', '=', 'documents.event_id')
            ->join('event_document_types as types', 'documents.event_document_type_id', '=', 'types.event_document_type_id')
            ->where('events.slug', $event_slug)
            ->where('documents.event_document_id', $document_id)
            ->whereNull('documents.deleted_at')
            ->select('documents.file as file', 'events.title as title', 'types.document_type as type')
            ->first())
        {
            $filePath = storage_path('/app/public/'. $document->file);
            $headers = ['Content-Type: application/pdf'];
            $fileName = Str::slug($document->title, '-') .'-' . Str::slug($document->type, '-') .'.pdf';
            return response()->download($filePath, $fileName, $headers);
        }
        else
            abort(404);
    }
    public function downloadAllDocument($event_slug)
    {
        if ($event = Event::where('slug', $event_slug)->first())
        {
            if ($event->documents->count() > 0)
            {
                $documents = $event->documents;
                $documentArray = array();
                foreach($documents as $document)
                {
                    $filePath = storage_path('/app/public/'. $document->file);
                    array_push($documentArray, $filePath);
                }
                $merger = new Merger;
                $merger->addIterator($documentArray);
                $mergedPDF = $merger->merge();
                $fileName = Str::slug($event->title, '-') . '-compiled-supporting-documents-' . date('F-d-Y');
                file_put_contents(storage_path('/app/public/compiledDocuments/' . $fileName . '.pdf'), $mergedPDF);
                // $filePath = storage_path('/app/public/'. $document->file);
                // $headers = ['Content-Type: application/pdf'];
                // $fileName = Str::slug($document->title, '-') .'-' . Str::slug($document->type, '-') .'.pdf';
                // return response()->download($filePath, $fileName, $headers);
            }
            else
            {
                // return no documents
                abort(404);
            }
        }
        else
            abort(404);
    }

    /* FilePond JS
     * Upload Functions
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
