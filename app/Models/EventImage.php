<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventImage extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'event_image_id';
    protected $table = 'event_images';

    public function event()
    {
    	return $this->belongsTo(Event::class, 'accomplished_event_id');
    }
}
