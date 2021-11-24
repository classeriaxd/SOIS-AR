<?php

namespace App\Services\EventServices;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;

use App\Services\EventServices\EventGetOrganizationIDService;

class EventIndexService
{
    /**
     * Service to show Index of Events.
     * Returns Events Array on Success.
     * @return Collection
     */
    public function index()
    {
        $events = Event::with('eventRole',
                'eventCategory',
                'eventLevel',
            )
            ->where('organization_id', (new EventGetOrganizationIDService)->getOrganizationID(),)
            ->orderByRaw('MONTH(`start_date`) ASC, `start_date` ASC')
            ->paginate(30);
        return $events;
    }
}
