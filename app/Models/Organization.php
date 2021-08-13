<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'organization_id';
    protected $table = 'organizations';
    
    public function events()
    {
    	return $this->hasMany(Event::class, 'organization_id');
    }

    public function courses()
    {
        return $this->hasMany(Courses::class, 'organization_id');
    }
}
