<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpcomingEvent extends Model
{
    protected $primaryKey = 'upcoming_event_id';
    protected $table = 'upcoming_events';
    
    public function accomplishedEvents()
    {
        return $this->belongsTo(Event::class, 'accomplished_event_id');
    }

}
