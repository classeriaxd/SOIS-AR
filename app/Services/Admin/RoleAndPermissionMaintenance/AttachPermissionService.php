<?php

namespace App\Services\Admin\RoleAndPermissionMaintenance;

use App\Models\User;

class AttachPermissionService
{
    /**
     * @param Integer $userID, Integer $permissionID
     * Service to attach a Permission to User
     * Attaches Session Data on Success/Failure
     * @return void
     */
    public function attach($userID, $permissionID)
    {
        try 
        {
            $user = User::where('user_id', $userID)->first();
            $user->permissions()->attach($permissionID);
            session()->flash('success', 'Successfully attached permission!');
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            session()->flash('error', 'Error in attaching permission: ' . $e->getMessage());
        }
    }
}
