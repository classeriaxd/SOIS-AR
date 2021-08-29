<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'event_id';
    protected $table = 'events';
    
    public function eventImages()
    {
    	return $this->hasMany(EventImage::class, 'event_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function eventRole()
    {
        return $this->belongsTo(EventRole::class, 'event_role_id');
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function documents()
    {
        return $this->hasMany(EventDocument::class, 'event_id');
    }
}
