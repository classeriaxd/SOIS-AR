<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventUpdateService
{
    /**
     * @param Request $request, String $oldEventSlug
     * Service to Update an event.
     * Returns New Event Slug on success.
     * @return String
     */
    public function update($request, $oldEventSlug): array
    {
        $newEventSlug = Str::slug($request->input('title'), '-') . '-' . Carbon::parse($request->input('startDate'))->format('Y') . '-' . Str::uuid();
        $eventData = [
            'event_role_id' => $request->input('eventRole'),
            'event_category_id' => $request->input('eventCategory'),
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
            'sponsors' => $request->input('sponsors'),
            'budget' => $request->input('budget'),
            'slug' => $newEventSlug,
        ];

        try 
        {
            Event::where('slug', $oldEventSlug)->update($eventData);
            $returnArray = array(
                'eventSlug' => $newEventSlug, 
                'message' => array('success' => 'Event updated sucessfully!'),
            );
            return $returnArray;
        } 

        catch (\Illuminate\Database\QueryException $e) 
        {
            $returnArray = array(
                'eventSlug' => NULL, 
                'message' => array('error' => 'Error in updating Event:' . $e->getMessage()),
            );
            return $returnArray;
        }
    }
}
