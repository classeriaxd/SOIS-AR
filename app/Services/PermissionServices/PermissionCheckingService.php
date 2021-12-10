<?php

namespace App\Services\PermissionServices;

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionCheckingService
{
    /**
     * @param String $permission, Integer $userID
     * Service check the permissions assigned to a user.
     * Returns true if the permission collection returned in the query is not empty
     * @return Boolean
     */
    public function checkIfPermissionAllows($permission): bool
    {
        if (Permission::where('name', $permission)->exists())
        {
            $permissionID = Permission::where('name', $permission)->value('permission_id');
            if ((Auth::user()->permissions->where('permission_id', $permissionID))->isNotEmpty())
                return true;
        }
        return false;
    }
}
