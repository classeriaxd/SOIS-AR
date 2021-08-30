<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $guarded = [];
    protected $primaryKey = 'event_category_id';
    protected $table = 'event_categories';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_category_id');
    }
}
