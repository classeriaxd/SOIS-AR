<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $primaryKey = 'level_id';
    protected $table = 'levels';

    public function events()
    {
        return $this->hasMany(Event::class, 'level_id');
    }

    public function studentAccomplishments()
    {
        return $this->hasMany(studentAccomplishments::class, 'level_id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * Scope a query to minimize returned columns.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyLevelColumns($query)
    {
        // similar to Model::select('primary_key', 'column')
        return $query->select($this->primaryKey, 'level');
    }
}
