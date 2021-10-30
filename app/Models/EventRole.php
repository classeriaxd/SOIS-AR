<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventRole extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $primaryKey = 'event_role_id';
    protected $table = 'event_roles';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_role_id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * Scope a query to minimize returned columns.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyEventRoleColumns($query)
    {
        // similar to Model::select('primary_key', 'column')
        return $query->select($this->primaryKey, 'event_role');
    }
}
