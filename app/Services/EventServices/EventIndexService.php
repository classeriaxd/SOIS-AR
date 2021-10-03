<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventIndexService
{
    /**
     * Service to show Index of Events.
     * Returns Events Array on Success.
     *
     * @return Collection
     */
    public function index()
    {
        // $allEventYears = Event::selectRaw('YEAR(`start_date`) as year')
        //     ->where('organization_id', Auth::user()->course->organization_id,)
        //     ->groupBy('year')
        //     ->orderBy('year', 'DESC')
        //     ->get();
        // $events = array();
        // foreach($allEventYears as $year) 
        // {
        //     $yearEvents = Event::whereRaw('YEAR(`start_date`) = ?', $year->year)
        //         ->where('organization_id', Auth::user()->course->organization_id,)
        //         ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
        //         ->get();
        //     $events[$year->year] = $yearEvents; 
        // }
        $events = Event::with('eventRole',
                'eventCategory',
                'eventLevel',
            )
            ->where('organization_id', Auth::user()->course->organization_id,)
            ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
            ->get();
        return $events;
    }
}
