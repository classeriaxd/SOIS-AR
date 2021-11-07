<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventClassification extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    protected $primaryKey = 'event_classification_id';
    protected $table = 'event_classifications';

    public function events()
    {
        return $this->hasMany(Event::class, 'event_classification_id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * Scope a query to minimize returned columns.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyClassificationColumns($query)
    {
        // similar to Model::select('primary_key', 'column')
        return $query->select($this->primaryKey, 'classification');
    }
}
