<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventNature extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $primaryKey = 'event_nature_id';
    protected $table = 'event_natures';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_nature_id');
    }
}
