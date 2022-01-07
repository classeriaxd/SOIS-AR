<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

// Model For Accomplished Events Table
class Event extends Model
{
    use HasFactory, SoftDeletes, SearchableTrait;
    protected $guarded = [];
    protected $primaryKey = 'accomplished_event_id';
    protected $table = 'accomplished_events';
    protected $searchable = [
        'columns' => [
            'accomplished_events.title' => 10,
        ],];
    
    public function eventImages()
    {
    	return $this->hasMany(EventImage::class, 'accomplished_event_id');
    }
    public function eventImage()
    {
        return $this->hasOne(EventImage::class, 'accomplished_event_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function eventDocuments()
    {
        return $this->hasMany(EventDocument::class, 'accomplished_event_id');
    }
    public function eventDocument()
    {
        return $this->hasOne(EventDocument::class, 'accomplished_event_id');
    }
    public function eventRole()
    {
        return $this->belongsTo(EventRole::class, 'event_role_id')->withTrashed();
    }

    public function eventCategory()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id')->withTrashed();
    }

    public function eventFundSource()
    {
        return $this->belongsTo(FundSource::class, 'fund_source_id')->withTrashed();
    }
    
    public function eventLevel()
    {
        return $this->belongsTo(Level::class, 'level_id')->withTrashed();
    }

    public function eventClassification()
    {
        return $this->belongsTo(EventClassification::class, 'event_classification_id')->withTrashed();
    }

    public function eventNature()
    {
        return $this->belongsTo(EventNature::class, 'event_nature_id')->withTrashed();
    }
}
