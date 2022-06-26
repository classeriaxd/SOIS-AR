<?php

namespace App\Services\Admin\RoleAndPermissionMaintenance;

use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use App\Services\NotificationServices\Admin\AdminNotificationService;

class AttachRoleService
{
    /**
     * @param Request $request, Integer $userID
     * Service to attach a Role and its Permissions to a User
     * Returns Message on Success/Failure
     * @return Array
     */
    public function attach($request, $userID): array
    {
        try 
        {
            $user = User::where('user_id', $userID)->first();
            $user->roles()->attach($request->role, ['organization_id' => $request->organization]);
            $rolePermissions = Permission::whereHas(
                'roles', function(Builder $query) use($request){
                    $query->where('permission_role.role_id', $request->role);},)
                ->orderBy('permission_id')
                ->pluck('permission_id')
                ->flatten()->toArray();
            $user->permissions()->attach($rolePermissions);

            // Send Notification to Member/Officer for the new Role
            $roleName = Role::where('role_id', $request->role)->value('role');
            $organizationName = Organization::where('organization_id', $request->organization)->value('organization_name');
            $notification = (new AdminNotificationService())
                ->sendNotificationForRoleAssignment(
                    $userID,
                    $user->email,
                    $user->full_name,
                    'A new Role has been assigned to your Account',
                    'The role ' . $roleName . ' of the ' . $organizationName . ' Organization has been assigned to your account by the System Admin.'
                );

            $message = array('success' => 'Successfully attached role!');
            return $message;
        } 
        catch (\Illuminate\Database\QueryException $e) 
        {
            $message = array('error' => 'Error in attaching role: ' . $e->getMessage());
            return $message;
        }
    }
}
