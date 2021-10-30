<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventStoreService
{
    /**
     * @param Request $request, Integer $organizationID
     * Service to Store an event.
     * Returns Event Slug and Message on success.
     * @return Array
     */
    public function store($request, $organizationID): array
    {
        try
        {
            $eventSlug = Event::create([
                'organization_id' => $organizationID,
                'event_role_id' => $request->input('eventRole'),
                'event_category_id' => $request->input('eventCategory'),
                'event_classification_id' => $request->input('eventClassification'),
                'event_nature_id' => $request->input('eventNature'),
                'fund_source_id' => $request->input('fundSource'),
                'level_id' => $request->input('level'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'objective' => $request->input('objective'),
                'start_date' => $request->input('startDate'),
                'end_date' => $request->input('endDate'),
                'start_time' => $request->input('startTime'),
                'end_time' => $request->input('endTime'),
                'venue' => $request->input('venue'),
                'activity_type' => $request->input('activityType'),
                'beneficiaries' => $request->input('beneficiaries'),
                'total_beneficiary' => $request->input('totalBeneficiary'),
                'sponsors' => $request->input('sponsors', NULL),
                'budget' => $request->input('budget', NULL),
                'slug' => Str::slug($request->input('title'), '-') . '-' . Carbon::parse($request->input('startDate'))->format('Y') . '-' . Str::uuid(),
            ])->slug;
            $returnArray = array(
                'eventSlug' => $eventSlug, 
                'message' => array('success' => 'Event added sucessfully!'),
            );
            return $returnArray;
        }
        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'eventSlug' => NULL, 
                'message' => array('error' => 'Error in Storing Event:' . $e->getMessage()),
            );
            return $returnArray;
        }
        
    }
}
