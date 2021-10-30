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
        return $this->hasMany(Event::class, $this->primaryKey);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * Scope a query to minimize returned columns.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetCategoriesWithMinimizedColumns($query)
    {
        return $query->select($this->primaryKey, 'category')->get();
    }
}
