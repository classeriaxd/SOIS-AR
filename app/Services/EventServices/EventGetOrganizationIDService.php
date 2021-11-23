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
    public function getOrganizationID(): int
    {
        // Pluck all User Roles
        $userRoleCollection = Auth::user()->roles;

        // Remap User Roles into array with Organization ID
        $userRoles = array();
        foreach ($userRoleCollection as $role) 
        {
            array_push($userRoles, ['role' => $role->role, 'organization_id' => $role->pivot->organization_id]);
        }
        
        // Get Organization ID from role "AR Officer Admin"
        $userRoleKey = array_search('AR Officer Admin', array_column($userRoles, 'role'));

        $organizationID = $userRoles[$userRoleKey]['organization_id'];

        return $organizationID;

    }
}
