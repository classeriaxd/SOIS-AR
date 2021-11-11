<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Organization;

use App\Http\Controllers\Controller as Controller;

class AdminEventsController extends Controller
{
    protected $viewDirectory = 'admin.events.';
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
        $events = Event::with(
                'organization:organization_id,organization_acronym,organization_slug',
                'eventRole:event_role_id,event_role,background_color,text_color',
                'eventCategory:event_category_id,category,background_color,text_color',
                'eventLevel:level_id,level',)
            ->orderBy('start_date', 'DESC')
            ->paginate(30);

        $organizations = Organization::with('logos:organization_id,file')
            ->orderBy('organization_type_id', 'ASC')
            ->get();

        return view($this->viewDirectory . 'index', 
            compact(
                'events',
                'organizations',
            ));
        
    }
    public function organizationIndex($organization_slug)
    {
        abort_if(($organization = Organization::where('organization_slug', $organization_slug)->select('organization_id', 'organization_acronym')->first()) !== NULL ? false : true, 404);
        $organizationLogo = $organization->logo->file;
        $events = Event::with(
                'organization:organization_id,organization_acronym,organization_slug',
                'eventRole:event_role_id,event_role,background_color,text_color',
                'eventCategory:event_category_id,category,background_color,text_color',
                'eventLevel:level_id,level',)
            ->orderBy('start_date', 'DESC')
            ->where('organization_id', $organization->organization_id)
            ->paginate(30);
        return view($this->viewDirectory . 'organizationIndex', 
            compact(
                'events',
                'organization',
                'organizationLogo',
            ));
    }
    public function show($organization_slug, $event_slug)
    {
        abort_if(($organization_id = Organization::where('organization_slug', $organization_slug)->value('organization_id')) !== NULL ? false : true, 404);
        abort_if(! Event::where('slug', $event_slug)->where('organization_id', $organization_id)->exists(), 404);
        
        
        $event = Event::with(
                'eventRole:event_role_id,event_role,background_color,text_color,deleted_at',
                'eventCategory:event_category_id,category,background_color,text_color,deleted_at',
                'eventFundSource:fund_source_id,fund_source,deleted_at',
                'eventLevel:level_id,level,deleted_at',
                'eventClassification:event_classification_id,classification,deleted_at',
                'eventNature:event_nature_id,nature,deleted_at',
                'eventImages:accomplished_event_id,event_image_id,image,caption,image_type',
                'eventDocuments:accomplished_event_id,event_document_id,event_document_type_id,title,description,file',
                'eventDocuments.documentType:event_document_type_id,document_type',
                'organization:organization_id,organization_acronym,organization_slug',
                'organization.logo:organization_id,file',)
            ->where('slug', $event_slug)
            ->first();

        return view($this->viewDirectory . 'show', 
            compact(
                'event',
            ));
    }

}
