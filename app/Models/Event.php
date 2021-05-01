<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function eventImages()
    {
    	return $this->hasMany(EventImage::class, 'event_id');
    }
}
