<?php

namespace App\Http\Controllers\Admin\UserMaintenance;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

use App\Models\{
    Role,
    User,
    Permission,
    Organization,
};

use App\Http\Requests\Admin\UserMaintenance\{
    UserRoleAttachRequest,
    UserRoleDetachRequest,
};
use App\Services\Admin\RoleAndPermissionMaintenance\{
    AttachPermissionService,
    DetachPermissionService,
    AttachRoleService,
    DetachRoleService,
};

use App\Services\PermissionServices\PermissionCheckingService;
use App\Http\Controllers\Controller as Controller;

class AdminRolesController extends Controller
{
    protected $viewDirectory = 'admin.roles.';
    protected $permissionChecker;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->permissionChecker = new PermissionCheckingService();
    }

    /**
     * Function to show Index Page showing all Roles for AR
     * @return View
     */
    public function index()
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);

        $memberCount = Role::withCount('users')
            ->where('role', 'User')
            ->first();
        $presidentCount = Role::withCount('users')
            ->where('role', 'AR President Admin')
            ->first();
        $officerCount = Role::withCount('users')
            ->where('role', 'AR Officer Admin')
            ->first();

        $loadHomeCSS = true;
        return view($this->viewDirectory . 'index', 
            compact(
                'memberCount',
                'presidentCount',
                'officerCount',
                'loadHomeCSS',
            ));
    }

    /**
     * @param String $roleName
     * Function to show Index Page showing a specific Role and its users
     * @return View
     */
    public function roleIndex($roleName)
    {
        $allowedRoles = ['members', 'officers', 'presidents'];
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! ((array_search($roleName, $allowedRoles, true)) !== false), 404);

        $breadcrumbRole = Str::ucfirst($roleName);

        $role = Role::with('usersWithOrganization')
                ->when($roleName === 'members', function ($query){
                    $query->where('role', 'User');})
                ->when($roleName === 'officers', function ($query){
                    $query->where('role', 'AR Officer Admin');})
                ->when($roleName === 'presidents', function ($query){
                    $query->where('role', 'AR President Admin');})
            ->first();

        return view($this->viewDirectory . 'roleIndex', 
            compact(
                'role',
                'breadcrumbRole',
            ));
    }

    /**
     * @param Integer $user_id
     * Function to show a specific User and its Roles and Permissions
     * @return View
     */
    public function userShow($user_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        // Query the System-Specific Roles and Permissions ONLY
        $allowedRolesForAR = ['AR Officer Admin', 'AR President Admin', 'User'];
        $allowedPermissionsForAR = Permission::whereHas(
            'roles', function(Builder $query) use($allowedRolesForAR){
                $query->whereIn('role', $allowedRolesForAR);},)
            ->orderBy('permission_id')
            ->pluck('name');
        $allowedPermissionsForAR = $allowedPermissionsForAR->flatten()->toArray();
        
        // Query User using the system-specific roles and permissions
        $user = User::with([
            'rolesWithOrganization' => function ($query) use ($allowedRolesForAR){
                $query->whereIn('role', $allowedRolesForAR);}, 
            'permissions' => function ($query) use ($allowedPermissionsForAR){
                $query->whereIn('name', $allowedPermissionsForAR)->orderBy('permission_id');}])
            ->where('user_id', $user_id)
            ->first();
        $userRoles = ($user->rolesWithOrganization->map->only('role'))->flatten()->toArray();
        $userPermissions = ($user->permissions->map->only('permission_id'))->flatten()->toArray();
        
        // Query Unassigned Permission using system-specific roles and permissions
        $unassignedPermissions = Permission::whereHas(
            'roles', function(Builder $query) use($userRoles, $allowedRolesForAR){
                $query->whereIn('role', $userRoles)->whereIn('role', $allowedRolesForAR);},)
            ->whereNotIn('permission_id', $userPermissions)
            ->orderBy('permission_id')
            ->get();
        
        return view($this->viewDirectory . 'userShow', 
            compact(
                'user',
                'unassignedPermissions'
           ));
    }

    /**
     * @param Integer $user_id
     * Function to show the Roles of a Specific User
     * @return View
     */
    public function userRoleIndex($user_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        $allowedRolesForAR = ['AR Officer Admin', 'AR President Admin', 'User'];
        $attachableRolesForAR = ['AR Officer Admin', 'AR President Admin'];

        // Query User using the system-specific roles
        $user = User::with([
            'rolesWithOrganization' => function ($query) use ($allowedRolesForAR){
                $query->whereIn('role', $allowedRolesForAR);},])
            ->where('user_id', $user_id)
            ->first();

        // Determine if User has any AR System-Specific Roles (Officer/President)
        $userRoles = ($user->rolesWithOrganization->map->only('role'))->flatten()->toArray();
        foreach ($userRoles as $userRole) 
        {
            if ((array_search($userRole, $attachableRolesForAR, true)) === false)
                $allowAttachRole = true;
            else
            {
                $allowAttachRole = false;
                break;
            }
        }
        
        $roles = collect(NULL);
        $organizations = collect(NULL);

        // If User does not have any AR System Specific Roles (Officer/President)...
        if ($allowAttachRole)
        {
            $roles = Role::whereIn('role', $attachableRolesForAR)->get();
            $organizations = Organization::select('organization_id', 'organization_acronym', 'organization_name')->get();
        }
        else
        {
            $roles = $user->rolesWithOrganization->whereIn('role', $attachableRolesForAR);
        }

        return view($this->viewDirectory . 'userRoleIndex', 
            compact(
                'user',
                'allowAttachRole',
                'roles',
                'organizations',
           ));
    }

    /**
     * @param Request $request, Integer $user_id
     * Function to attach a Role and its Permissions on a Specific User
     * @return Redirect
     */
    public function userRoleAttach(UserRoleAttachRequest $request, $user_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        $message = (new AttachRoleService())->attach($request, $user_id);

        return redirect()->action(
            [AdminRolesController::class, 'userShow'], ['user_id' => $user_id])
            ->with($message);
    }

    /**
     * @param Request $request, Integer $user_id
     * Function to detach a Role and its Permissions on a Specific User
     * @return Redirect
     */
    public function userRoleDetach(UserRoleDetachRequest $request, $user_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        $message = (new DetachRoleService())->detach($request, $user_id);

        return redirect()->action(
            [AdminRolesController::class, 'userShow'], ['user_id' => $user_id])
            ->with($message);
    }

    /**
     * @param Integer $user_id, Integer $permission_id
     * Vue Function -> Permission/AttachPermission.vue
     * Function to attach a Permission on a Specific User
     * @return void
     */
    public function attachPermission($user_id, $permission_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        (new AttachPermissionService())->attach($user_id, $permission_id);
    }

    /**
     * @param Integer $user_id, Integer $permission_id
     * Vue Function -> Permission/DetachPermission.vue
     * Function to detach a Permission on a Specific User
     * @return void
     */
    public function detachPermission($user_id, $permission_id)
    {
        abort_if(! $this->permissionChecker->checkIfPermissionAllows('AR-Super-Admin-Manage_Roles_and_Permissions'), 403);
        abort_if(! User::where('user_id', $user_id)->exists(), 404);

        (new DetachPermissionService())->detach($user_id, $permission_id);
    }
}
