<?php

namespace App\Services\EventServices;

use Illuminate\Support\Facades\Auth;

class EventGetOrganizationIDService
{
    /**
     * Service to get Organization ID of User.
     * Returns Organization ID on success.
     * @return Integer
     */
    public function getOrganizationID()
    {
        $organizationID = Auth::user()->positionTitles->whereIn('position_title', ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'])->pluck('organization_id')->first();
        return $organizationID;
    }
}
