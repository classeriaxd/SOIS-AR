<?php

namespace App\Services\Admin\RoleAndPermissionMaintenance;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

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
