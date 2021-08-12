<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'course_id';
    protected $table = 'courses';
    
    public function users()
    {
    	return $this->hasMany(User::class, 'course_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
