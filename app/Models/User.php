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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function positionTitles()
    {
        return $this->belongsToMany(PositionTitle::class, 'users_position_titles');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function studentAccomplishments()
    {
        return $this->hasMany(studentAccomplishments::class, 'user_id');
    }

    /**
     * Get the user's full concatenated name.
     * -- Must postfix the word 'Attribute' to the function name
     * @return string
     */

    public function getFullNameAttribute()
    {
        if ($this->suffix === NULL)
            return "{$this->last_name}, {$this->first_name} {$this->middle_name}";
        else
            return "{$this->last_name}, {$this->first_name} {$this->middle_name} {$this->suffix}";
    }
}
