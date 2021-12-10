<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')
            ->withPivot('organization_id');
    }
    public function usersWithOrganization()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')
            ->withPivot('organization_id')
            ->join('organizations as role_organization', 'role_user.organization_id', 'role_organization.organization_id')
            ->select('users.user_id', 'users.last_name', 'users.first_name', 'users.middle_name', 'users.suffix', 'users.student_number','role_organization.organization_id', 'role_organization.organization_acronym');
    }
}
