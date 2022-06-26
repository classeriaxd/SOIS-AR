<?php

namespace App\Services\Admin\RoleAndPermissionMaintenance;

use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use App\Services\NotificationServices\Admin\AdminNotificationService;

class DetachRoleService
{
    /**
     * @param Request $request, Integer $userID
     * Service to attach a Role and its Permissions to a User
     * Returns Message on Success/Failure
     * @return Array
     */
    public function detach($request, $userID): array
    {
        try 
        {
            $user = User::where('user_id', $userID)->first();
            $user->roles()->detach($request->role);
            $rolePermissions = Permission::whereHas(
                'roles', function(Builder $query) use($request){
                    $query->where('permission_role.role_id', $request->role)
                        ->whereNotIn('permission_role.permission_id',[18,19,31]);
                },)
                ->orderBy('permission_id')
                ->pluck('permission_id')
                ->flatten()->toArray();
            $user->permissions()->detach($rolePermissions);

            // Send Notification to Member/Officer for the detached Role
            $roleName = Role::where('role_id', $request->role)->value('role');
            $notification = (new AdminNotificationService())
                ->sendNotificationForRoleDetachment(
                    $userID,
                    $user->email,
                    $user->full_name,
                    'A Role has been detached from your Account',
                    'The role ' . $roleName . ' has been detached on your account by the System Admin.'
                );

            $message = array('success' => 'Successfully detached role!');
            return $message;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $message = array('error' => 'Error in detaching role: ' . $e->getMessage());
            return $message;
        }
    }
}
