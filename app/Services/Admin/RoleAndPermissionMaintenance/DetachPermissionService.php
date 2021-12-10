<?php

namespace App\Services\Admin\RoleAndPermissionMaintenance;

use App\Models\User;

class DetachPermissionService
{
    /**
     * @param Integer $userID, Integer $permissionID
     * Service to detach a Permission to User
     * Attaches Session Data on Success/Failure
     * @return void
     */
    public function detach($userID, $permissionID)
    {
        try 
        {
            $user = User::where('user_id', $userID)->first();
            $user->permissions()->detach($permissionID);
            session()->flash('success', 'Successfully detached permission!');
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            session()->flash('error', 'Error in detaching permission: ' . $e->getMessage());
        }
    }
}
