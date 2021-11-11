<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;

use App\Http\Controllers\Controller as Controller;

class AdminOrganizationsController extends Controller
{
    protected $viewDirectory = 'admin.organizations.';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organizations = Organization::with('logo');
        return view($this->viewDirectory . 'index', 
            compact(
                'organizations',
            ));
        
    }
    public function show($organization_slug)
    {
        abort_if(! Organization::where('slug', $organization_slug)->exists(), 404);
        
        // $event = Organization::with(
        //         'eventRole:event_role_id,event_role,background_color,text_color,deleted_at',
        //         'eventCategory:event_category_id,category,background_color,text_color,deleted_at',
        //         'eventFundSource:fund_source_id,fund_source,deleted_at',
        //         'eventLevel:level_id,level,deleted_at',
        //         'eventClassification:event_classification_id,classification,deleted_at',
        //         'eventNature:event_nature_id,nature,deleted_at',
        //         'eventImages:accomplished_event_id,event_image_id,image,caption,image_type',
        //         'eventDocuments:accomplished_event_id,event_document_id,event_document_type_id,title,description,file',
        //         'eventDocuments.documentType:event_document_type_id,document_type',
        //         'organization:organization_id,organization_acronym',
        //         'organization.logo:organization_id,file',)
        //     ->where('slug', $event_slug)
        //     ->first();

        // return view($this->viewDirectory . 'show', 
        //     compact(
        //         'event',
            ));
    }

}
