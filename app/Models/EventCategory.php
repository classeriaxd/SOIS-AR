<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $primaryKey = 'event_category_id';
    protected $table = 'event_categories';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_category_id');
    }
}
