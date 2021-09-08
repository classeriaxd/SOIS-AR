<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EventDocuments;
use App\Models\Course;
use App\Models\OrganizationDocument;
use App\Models\OrganizationDocumentType;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class OrganizationDocumentController extends Controller
{
    public function create()
    {
        $org = Auth::user()->course->organization_id;
        //dd($org);
        $doctypes = OrganizationDocumentType::where('org_id', $org)->select('orgdoctype_id', 'doctype', 'org_id')->get();
        //dd($doctypes);
    	return view('eventdocuments.create', compact('doctypes'));
    }

    public function store()
    {
        $org = Auth::user()->course->organization_id;        
        $data = request()->validate([
            'document_type' => 'required|exists:organization_document_types,orgdoctype_id',
            'file' => 'nullable',
            'title' => 'required',
            'description' => 'required',

        ]);	

        $orgdoc_id = OrganizationDocument::create([
            'org_id' => $org,
            'orgdoc_type_id' => $data['document_type'],
            'file' => $data['file'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    	 //return redirect()->route('show', compact('notices'));
            return redirect('home');
    }
}

