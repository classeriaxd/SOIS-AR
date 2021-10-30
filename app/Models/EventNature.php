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

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * Scope a query to minimize returned columns.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyNatureColumns($query)
    {
        // similar to Model::select('primary_key', 'column')
        return $query->select($this->primaryKey, 'nature');
    }
}
