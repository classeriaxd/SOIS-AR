<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];
    
    protected $primaryKey = 'user_id';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withPivot('organization_id');
    }
    public function rolesWithOrganization()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->withPivot('organization_id')
            ->join('organizations as role_organization', 'role_user.organization_id', 'role_organization.organization_id')
            ->select('roles.role_id', 'roles.role','role_organization.organization_id', 'role_organization.organization_acronym');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user', 'user_id', 'permission_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function studentAccomplishments()
    {
        return $this->hasMany(StudentAccomplishments::class, 'user_id');
    }

    public function dataLogs()
    {
        return $this->hasMany(DataLog::class, 'user_id')->orderBy('created_at', 'DESC');
    }

    /**
     * Get the user's full concatenated name.
     * @return string
     */
    public function getFullNameAttribute()
    {
        $name = "{$this->last_name}, {$this->first_name}";

        if (! $this->middle_name === NULL)
            $name .= " {$this->middle_name}";
        if (! $this->suffix === NULL)
            $name .= " {$this->suffix}";

        return $name;
    }
}
